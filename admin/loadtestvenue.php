<?php

$add=array(
		array('23.022505','72.571362'),
		array('22.9995','72.6003'),
		array('23.038696','72.630753'),
		array('23.012034','72.510754'),
		array('23.033167','72.558704'),
		array('23.031688','72.534532'),
		array('23.052379','72.602613'),
		array('22.998377','72.442302'),
		array('23.033800','72.546584'),
		array('23.128104','72.544161'),
		array('23.075715','72.508867'),
		array('23.163747','72.581851'),
		array('23.053898','72.629446'),
		array('23.073426','72.626571'),
		array('23.033677','72.463412'),
		array('23.006489','72.458361'),
		array('23.004916','72.532534'),
		array('23.043441','72.549320'),
		array('22.966425','72.615933'),
		array('22.995185','72.632118'),
		array('23.029167','72.600278'),
		array('23.0483752','72.5139494'), //4 miles
		array('23.0456295','72.6729321'), //10 miles
		array('23.0168949','73.0752035'), //35 miles
		array('23.0092208','74.1573716'), //104 miles
		array('23.1959605','74.4506109'), //123 miles
		array('22.3221027','73.1730862'), //65 miles
		array('21.6267627','73.019456'), //103 miles
		array('21.1592002','72.8223832'), //132 miles
		array('19.9909631','73.8034808'), //227 miles
		array('20.3805019','72.9139021'), //186 miles
		array('21.7638776','72.1548588'), //91 miles
		array('21.5305662','70.4376099'), //169 miles
		array('20.9164918','70.3599191'), //202 miles
		array('26.9035788','70.8947302'), //285 miles
		array('28.6454415','77.0907573'), //480 miles
		array('28.6996531','77.3950283'), //494 miles
		array('26.8852108','75.7905578'), //335 miles
		array('26.0266974','76.3663101'), //317 miles
		array('25.3414206','74.6317362'), //207 miles
		array('22.7281031','75.8532572'), //207 miles
		
);





require_once ("system/config.php");
global $DAO;

for ($i = 2000; $i < 5000; $i++) {
	$name = "venue_$i";
	$imagefilename = '';
	$description = "description_$i";
	$highlighted_text = "highligh_$i";
	$email = "venue$i@test.com";
	
	$k = array_rand($add);
	$v = $add[$k];

	$latitude = $v[0];
	$longitude = $v[1];
	$manager_id = 0;
	$category_id = 1;
	$contact_no = 54555456456;
	$notification = 1;
	$address = "address_$i";

	$photo = $imagefilename;
	$now = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `venue` (`name`,
									 `business_logo`,									 
									 `description`,
									 `highlighted_text`,
									 `email`,
									 `latitude`,
									 `longitude`,
									 `status`,
									 `manager_id`,
									 `category_id`,
									 `contact_no`,
									 `address`,
									 `created_datetime`,
									 `notification`) 
								VALUES
									 ('" . $name . "',
									  '" . $imagefilename . "',									  
									  '" . $description . "',
									  '" . $highlighted_text . "',
									  '" . $email . "',
									  '" . $latitude . "',
									  '" . $longitude . "',
									  '1',
									  $manager_id,
									  $category_id,
									  '" . $contact_no . "',
									  '" . $address . "',
									  '" . $now . "',
									  '$notification')";
	$q = $DAO -> insertquery($sql);
}
?>
