<?php
require_once ("system/config.php");
require_once("classes/paypal.class.php");
if(count($_SESSION['user'])==0){
	header("Location: login.php");
    die();
}else{
    $result = checkUserToken();	
   if(!$result){
  		 header("Location: logout.php?token=invalid");
         die();
    }
}
$venueobj = (object) new venue();
$subscriptionobj = (object) new subscription();
$paymentobj = (object) new payment();
if(isset($_POST['add_payment']) or isset($_POST['extend_payment']))
{
		
	$subscription_id = inputString($_REQUEST['subscription_id']);
	
	
	if(!$_REQUEST['no_update'])
	{
		if($_SESSION['venueoperation'] == "edit")
		{
			unset($_SESSION['venueoperation']);  
			header('Location:venue.php?msg=3');
		}
		else if($_SESSION['venueoperation'] == "add")
		{
			unset($_SESSION['venueoperation']);
			header('Location:venue.php?msg=2');
		}
		else
		{
			unset($_SESSION['venueoperation']);
			header('Location:venue.php?msg=3');
		}
		header("Location: venue.php?msg=3"); 			
		die();	
	}
	
	
	/*
	if($subscription_id == 1)
	{
		
		if($_SESSION['venueoperation'] == "edit")
		{
			unset($_SESSION['venueoperation']);  
			header('Location:venue.php?msg=3');
		}
		else if($_SESSION['venueoperation'] == "add")
		{
			unset($_SESSION['venueoperation']);
			header('Location:venue.php?msg=2');
		}
		else
		{
			unset($_SESSION['venueoperation']);
			header('Location:venue.php?msg=3');
		}
		header("Location: venue.php?msg=9"); 			
		die();			
	}
	 * 
	 */
	$venue_id = inputString($_REQUEST['venue_id']);
	$recurring = 0;
	if(isset($_REQUEST['recurring_on']))
	{
		$recurring = 1;
	}
	
	if($venue_id =="")
	{
		header("Location: vpayment.php?edit=$venue_id&msg=4");
     	die();
	}
	$result = $venueobj->venuedetailbyid($venue_id);
	if(count($result)==0)
	{
		header("Location: vpayment.php?msg=3");
   		die();
	
	}
	if($subscription_id =="")
	{
		header("Location: vpayment.php?edit=$venue_id&msg=4");
     	die();
	}
	
	
	$paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';	
	$subscriptiondata = $subscriptionobj->subscriptiondetailbyid($subscription_id);
	//echo "<pre>";print_r($subscriptiondata);die;
	$PayPalReturnURL = ROOT_PATH."vpayment.php?edit=".$venue_id;
	$PayPalCancelURL = ROOT_PATH."vpayment.php?edit=".$venue_id;
	

	$ItemName 		= $subscriptiondata[0]['name']; 
	$ItemPrice 		= $subscriptiondata[0]['price'];
	$_SESSION['payment']['discount_consume_id'] = 0;
	
	$sql = "select v.*,
					d.type 
				From 
					venue_discount v 
				LEFT JOIN 
					discount d 
				ON 
					v.discount_id = d.id 
				where 
					v.venue_id=".$venue_id." 
					AND 
					v.subscription_id = ".$subscription_id." 
					AND d.type='percentage'";
	$discount_percentage_result = $DAO->select($sql);
	
	if(isset($discount_percentage_result[0]['id']))
	{
		$ItemPrice = ($ItemPrice*($discount_percentage_result[0]['value']/100));
		$ItemPrice = $subscriptiondata[0]['price'] - $ItemPrice;
		
		$_SESSION['payment']['discount_consume_id'] = $discount_percentage_result[0]['id'];
	}
	
	
	$sql = "select v.*,
				d.type 
			From 
				venue_discount v  
			LEFT JOIN 
				discount d 
			ON 
				v.discount_id = d.id 
			where v.venue_id=".$venue_id." 
				AND v.subscription_id = ".$subscription_id." 
				AND d.type='amount'";
	$discount_amount_result = $DAO->select($sql);
	
	if(isset($discount_amount_result[0]['id']))
	{
		$ItemPrice = $ItemPrice-$discount_amount_result[0]['value'];
		$_SESSION['payment']['discount_consume_id'] = $discount_amount_result[0]['id'];
	}
	
	
	$ItemPrice = round($ItemPrice,2);
	$ItemNumber 	= $subscriptiondata[0]['id']; 
	$ItemDesc 		= ''; 
	$ItemQty 		= ''; 
	$ItemTotalPrice = $ItemPrice; 
	

	$TotalTaxAmount 	= 0;   
	$HandalingCost 		= 0;  
	$InsuranceCost 		= 0;  
	$ShippinDiscount 	= 0; 
	$ShippinCost 		= 0; 
	
	
	$GrandTotal = ($ItemTotalPrice + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
	
	
	$padata = 	'&METHOD=SetExpressCheckout'.
				'&RETURNURL='.urlencode($PayPalReturnURL).
				'&CANCELURL='.urlencode($PayPalCancelURL).
				'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
				
				'&L_PAYMENTREQUEST_0_NAME0='.$ItemName.
				'&L_PAYMENTREQUEST_0_AMT0='.$ItemPrice.
				
				'&NOSHIPPING=1'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
				
				'&PAYMENTREQUEST_0_ITEMAMT='.$ItemTotalPrice.
				'&PAYMENTREQUEST_0_TAXAMT='.$TotalTaxAmount.
				'&PAYMENTREQUEST_0_SHIPPINGAMT='.$ShippinCost.
				'&PAYMENTREQUEST_0_HANDLINGAMT='.$HandalingCost.
				'&PAYMENTREQUEST_0_SHIPDISCAMT='.$ShippinDiscount.
				'&PAYMENTREQUEST_0_INSURANCEAMT='.$InsuranceCost.
				'&PAYMENTREQUEST_0_AMT='.$GrandTotal.
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
				//'&LOCALECODE=GB'. //PayPal pages to match the language on your website.
				//'&LOGOIMG=http://www.origzo.com/images/logo.png'. //site logo
				'&CARTBORDERCOLOR=FFFFFF'. //border color of cart
				'&ALLOWNOTE=1';
				
	if($recurring)
	{
			$padata .= "&L_BILLINGTYPE0=RecurringPayments&L_BILLINGAGREEMENTDESCRIPTION0=".$ItemName."_recurring";
	}	


	$_SESSION['payment']['ItemName'] 			=  $ItemName; 
	$_SESSION['payment']['ItemPrice'] 			=  $ItemPrice; 
	$_SESSION['payment']['ItemNumber'] 		=  $ItemNumber; 
	$_SESSION['payment']['ItemTotalPrice'] 	=  $ItemTotalPrice; 
	$_SESSION['payment']['TotalTaxAmount'] 	=  $TotalTaxAmount; 
 	$_SESSION['payment']['GrandTotal'] 		=  $GrandTotal;
	$_SESSION['payment']['venue_id']           = $venue_id;
	$_SESSION['payment']['recurring']           = $recurring;

	$paypal= new MyPayPal();
	$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	

	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
	{
		 	$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
			header('Location: '.$paypalurl);
		 
	}else{

		echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
		echo '<pre>';
		print_r($httpParsedResponseAr);
		echo '</pre>';
	}
}

if (isset($_REQUEST['edit']))
{
	$venue_id = inputString(trim($_REQUEST['edit']));
	if($venue_id !='' && is_numeric($venue_id))
	{
		$result = $venueobj->venuedetailbyid($venue_id);
		if($result[0]['recurring'])
		{
			header("Location: venue.php?msg=4");
       		die();	
		}
		if(count($result)==0)
		{
			header("Location: vpayment.php?msg=3");
       		die();
		}
		
		$paymentlast = $venueobj->lastpaymentvenuedetailbyid($venue_id);
	}
	else
	{
		header("Location: vpayment.php?msg=3");
       	die();
	}		
}
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{

	$token = $_GET["token"];
	$payer_id = $_GET["PayerID"];
	
	
	
	$ItemName 			= $_SESSION['payment']['ItemName']; 
	$ItemPrice 			= $_SESSION['payment']['ItemPrice'];
	$ItemNumber 		= $_SESSION['payment']['ItemNumber'];
	$ItemTotalPrice 	= $_SESSION['payment']['ItemTotalPrice'];  
	$TotalTaxAmount 	= $_SESSION['payment']['TotalTaxAmount'] ; 
	$GrandTotal 		= $_SESSION['payment']['GrandTotal'];
	$venue_id           = $_SESSION['payment']['venue_id'];
	
	
	
	$padata = 	'&TOKEN='.urlencode($token).
				'&PAYERID='.urlencode($payer_id).
				'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
				
				'&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
				'&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).
				'&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
	
				'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
				'&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
	
	
	$paypal= new MyPayPal();
	$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	
	
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
	{

				
				
				$paymentcomplete = 0;
				$paymentstatus = $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"];
				
				if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
				{
					$paymentcomplete = 1;
				}
				
				$padata = 	'&TOKEN='.urlencode($token);
				$paypal= new MyPayPal();
				$httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
				{
					
					$entryarray = array();
					$entryarray['user_id'] = $_SESSION['user']['user_id'];
					$entryarray['firstname'] = urldecode($httpParsedResponseAr["FIRSTNAME"]);
					$entryarray['lastname'] = urldecode($httpParsedResponseAr["LASTNAME"]);
					$entryarray['email'] = urldecode($httpParsedResponseAr["EMAIL"]);
					$entryarray['amount'] = urldecode($httpParsedResponseAr["L_AMT0"]);
					$entryarray['subscription_id'] = $httpParsedResponseAr["L_NUMBER0"];
					$entryarray['venue_id'] = $venue_id;
					$entryarray['transaction_id'] = $httpParsedResponseAr["PAYMENTREQUESTINFO_0_TRANSACTIONID"];
					$entryarray['paymentstatus'] = $paymentstatus;
					$entryarray['payer_id'] = urldecode($payer_id);
					$entryarray['created'] = date('Y-m-d H:i:s');
					
					$paymentobj->transactionentry($entryarray);
					if($paymentcomplete)
					{
						$subscriptiondata = $subscriptionobj->subscriptiondetailbyid($entryarray['subscription_id']);
						$paymentdata_response = $paymentobj->paymenttableentry($entryarray,$subscriptiondata);
						
						
						
						$venuelogresult = $venueobj->venuedetailbyid($venue_id);
						
						
						
						
						if($_SESSION['payment']['recurring'])
						{
							$profile_start_date = $paymentdata_response['end'];
							$billing_frequency = $subscriptiondata[0]['duration'];
							$amount =  $subscriptiondata[0]['price'];
							$desc = $subscriptiondata[0]['name'].'_recurring';
							 	
							$token = urldecode($token);	
							$payer_id = urldecode($payer_id);
							$recuStr = "&TOKEN=$token&PAYERID=$payer_id&AMT=$amount&CURRENCYCODE=USD&COUNTRYCODE=US&PROFILESTARTDATE=".$profile_start_date."T00:00:00.00Z";
							$recuStr .= "&BILLINGPERIOD=Day&BILLINGFREQUENCY=$billing_frequency&MAXFAILEDPAYMENTS=1&DESC=$desc";
							
							//$recuStr = "&TOKEN=$token&PAYERID=$payer_id&AMT=14.00&CURRENCYCODE=USD&COUNTRYCODE=US&PROFILESTARTDATE=2014-11-16T00:00:00";
							//$recuStr .= "&BILLINGPERIOD=Day&BILLINGFREQUENCY=1&DESC=$desc";
							
							
							$profile_httpParsedResponseAr = $paypal->PPHttpPost('CreateRecurringPaymentsProfile',$recuStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
							
							
							if("SUCCESS" == strtoupper($profile_httpParsedResponseAr['ACK']))
							{
								if($profile_httpParsedResponseAr['PROFILEID'])
								{
									global $DAO;
									$venue_update_array = array();
									$venue_update_array['recurring'] = 1;
									$venue_update_array['recurring_profile_id'] = urldecode($profile_httpParsedResponseAr['PROFILEID']);
									$venue_update_array['recurring_subscription'] = $subscriptiondata[0]['id'];
									$where = array('venue_id'=>$venue_id);
									$q = $DAO->update('venue',$venue_update_array,$where);
									
									
									$logmsg = "'".$venuelogresult[0]['name']."' purchase recurring '".$subscriptiondata[0]['name']."'";
									activitylog($_SESSION['user']['user_id'],$logmsg);
									
									header("Location: venue.php?msg=14");									
								}
							}
							else
							{
								header("Location: venue.php?msg=13");
							}	
								
						}
						else
						{
							$logmsg = "'".$venuelogresult[0]['name']."' purchase '".$subscriptiondata[0]['name']."'";
							activitylog($_SESSION['user']['user_id'],$logmsg);
							header("Location: venue.php?msg=9");
						}	
					}
					else
					{
						header("Location: venue.php?msg=12");
					}
	
				}
				else
				{
					
					header("Location: vpayment.php?edit=$venue_id&msg=3");
         			die();
					//echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					
				}
	
	}else{
			//echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				
			header("Location: vpayment.php?edit=$venue_id&msg=3");
         	die();
			
	}
}
$venueresult = $venueobj->venueidnamelist();
$result = $paymentobj->paymentlist();
$subscriptiontype = $paymentobj->subscriptionstype();


$sql = "select v.*,d.name,d.type From venue_discount v LEFT JOIN discount d ON v.discount_id = d.id where v.venue_id=".$venue_id;
$discount_result = $DAO->select($sql);

?>