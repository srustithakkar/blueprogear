<?php
require_once ("system/configipn.php");
require_once("classes/paypal.class.php");
$venueobj = (object) new venue();
$paypal= new MyPayPal();
global $DAO;
$allvenue = $venueobj->recurringvenue();
foreach ($allvenue as $value) {
	$sql = "select * From payments where venue_id=".$value['venue_id']." ORDER BY id Desc limit 0,1";
	$previos_result = $DAO->select($sql);
	if(strtotime($previos_result[0]['end']) == strtotime(date('Y-m-d')))
	{
		
		$padata = '&PROFILEID='.urlencode($value['recurring_profile_id']);
		$httpParsedResponseAr = $paypal->PPHttpPost('GetRecurringPaymentsProfileDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
		if($httpParsedResponseAr['STATUS'] == "Active")
		{
				
			$paymentdata = array();
			$paymentdata['user_id'] = $previos_result[0]['user_id'];
			$pos = strrpos($previos_result[0]['transaction_id'],"_cron");
			if($pos)
			{
				$paymentdata['transaction_id'] = $previos_result[0]['transaction_id'];
			} 
			else
			{
				$paymentdata['transaction_id'] = $previos_result[0]['transaction_id'].'_cron';
			}	 
			
			$paymentdata['venue_id'] = $previos_result[0]['venue_id'];
			$paymentdata['subscription_id'] = $previos_result[0]['subscription_id'];
			$paymentdata['price'] = $previos_result[0]["calculate_price"];
			$paymentdata['calculate_price'] = $previos_result[0]["calculate_price"];
			$paymentdata['duration'] =  $previos_result[0]['duration'];
			$paymentdata['payment_mode'] = "paypal";
			$paymentdata['payer_id'] = $previos_result[0]["payer_id"];
			$paymentdata['createtime'] = date('Y-m-d');
			$paymentdata['start'] = date('Y-m-d');
			$plusday = $paymentdata['duration'];
			$enddate_cal = strtotime(date('Y-m-d'));
			$enddate_cal = strtotime("+$plusday day", $enddate_cal);
			$paymentdata['end'] =  date('Y-m-d', $enddate_cal);
			$q = $DAO->insert('payments',$paymentdata);
			
			$logmsg = "Recurring amount received from '".$value['name']."'";
			activitylog($previos_result[0]['user_id'],$logmsg);
			
		}
		else
		{
			
			$padata = 	'&PROFILEID='.urlencode($value['recurring_profile_id']).'&ACTION=Cancel';
			$httpParsedResponseAr = $paypal->PPHttpPost('ManageRecurringPaymentsProfileStatus', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			$venue_update_array = array();
			$venue_update_array['recurring'] = 0;
			$venue_update_array['recurring_profile_id'] = '';
			$venue_update_array['recurring_subscription'] = 0;
			$where = array('venue_id'=>$value['venue_id']);
			$q = $DAO->update('venue',$venue_update_array,$where);
			$logmsg = "Canceled recurring account of '".$value['name']."'";
			activitylog(1,$logmsg);
		}		
	}
}		

?>