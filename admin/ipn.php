<?php

	require_once ("system/configipn.php");
	
	$venueobj = (object) new venue();
	$subscriptionobj = (object) new subscription();
	$paymentobj = (object) new payment();
	
	//$data = $_REQUEST;
	
	
	$data = array(
    				'mc_gross' => 15.00,
    				'period_type' =>  'Regular',
    				'outstanding_balance' => 0.00,
    				'next_payment_date' => '02:00:00 Nov 21, 2014 PST',
    				'protection_eligibility' => 'Ineligible',
    				'payment_cycle' => 'every 4 Days',
    				'address_status' => 'confirmed',
    				'tax' => 0.00,
   					'payer_id' => 'DQQPGMKGNGHCU',
    				'address_street' => '1 Main St',
    				'payment_date' => '10:11:55 Dec 06, 2014 PST',
    				'payment_status' => 'Completed',
   					'product_name' => 'package_recurring',
    				'charset' => 'windows-1252',
    				'recurring_payment_id' => 'I-A02K6KE58WLP',
    				'address_zip' => 95131,
    				'first_name' => 'vijay',
    				'mc_fee' => 0.74,
    				'address_country_code' => 'US',
    				'address_name' => 'vijay  ojha',
    				'notify_version' => 3.8,
    				'amount_per_cycle' => 15.00,
    				'payer_status' => 'verified',
    				'currency_code' => 'USD',
    				'business' => 'vijay.ojha@origzobus.com',
    				'address_country' => 'United States',
    				'address_city' => 'San Jose',
    				'verify_sign' => 'AxROwrSclI8tbbwzkdCUG5ki..66AgNIjTHBWXccTbWFbp3AltnQDm4P',
    				'payer_email' => 'vijay.ojha@origzo.com',
    				'initial_payment_amount' => 0.00,
    				'profile_status' => 'Active',
    				'amount' => 15.00,
    				'txn_id' => '9EP54024PX760374R',
    				'payment_type' => 'instant',
    				'last_name' => 'ojha',
    				'address_state' => 'CA',
    				'receiver_email' => 'vijay.ojha@origzobus.com',
    				'payment_fee' => 0.74,
    				'receiver_id' => 'RV2GUTUFZFW46',
    				'pending_reason' => 'paymentreview',
    				'txn_type' => 'recurring_payment',
    				'mc_currency' => 'USD',
   					'residence_country' => 'US',
    				'test_ipn' => 1,
    				'transaction_subject' => 'package_recurring',
    				'payment_gross' => 15.00,
    				'shipping' => 0.00,
    				'product_type' => 1,
    				'time_created' => '05:07:20 Nov 11, 2014 PST',
    				'ipn_track_id' => 'fb6afdc06461c'
				);	
	
	
	if($data['txn_type'] == "recurring_payment" and $data['payment_status'] == 'Completed')
	{
					$venueidbyprofile = $paymentobj->recurringvenuebyprofileid($data['recurring_payment_id']);
					
					if($venueidbyprofile[0]['venue_id'])
					{
						$sql = "select * From payments where venue_id=".$venueidbyprofile[0]['venue_id']." ORDER BY id Desc limit 0,1";
						$previous_payment = $DAO->select($sql);
						if($previous_payment[0]['id'])
						{
							$entryarray = array();
							$entryarray['user_id'] = $previous_payment[0]['user_id'];
							$entryarray['firstname'] = $data['first_name'];
							$entryarray['lastname'] = $data['last_name'];
							$entryarray['email'] = $data['payer_email'];
							$entryarray['amount'] = $data['amount'];
							$entryarray['subscription_id'] = $venueidbyprofile[0]['recurring_subscription']; 
							$entryarray['venue_id'] = $venueidbyprofile[0]['venue_id'];
							$entryarray['transaction_id'] = $data['txn_id'];
							$entryarray['paymentstatus'] = $data['payment_status'];
							$entryarray['payer_id'] = $data['payer_id'];
							$entryarray['created'] = date('Y-m-d H:i:s');
							$paymentobj->transactionentry($entryarray);
							$paymentdata_response = $paymentobj->recurringpaymenttableentry($entryarray);
						}	
			
					}		 
	}	
	
?>
