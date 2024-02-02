<?php
function sendPushnotification($deviceToken,$message,$fromUserId='',$fromUserName='',$appType='')
{
	$json 	= new Services_JSON();
	
	// Put your device token here (without spaces):
	//$deviceToken = '1c05b17e0c90d65bdd7da8f1b3c9901338306efa57755f6c5b73d3873e4315c5';
	
	// Put your private key's passphrase here:
	
	//echo "\n \n ".$deviceToken;
	//echo "\n \n ".$message.
	$passphrase = '';
	
	// Put your alert message here:
	//$message = 'My first push notification!';
	//$appType='';
	////////////////////////////////////////////////////////////////////////////////
	
	$ctx = stream_context_create();
	
	if($appType == "full")
	{
		$pushFileDirectory = "push_dist_full_dir/ck.pem";
	}
	else if($appType == "lite")
	{
		$pushFileDirectory = "push_dist_lite_dir/ck.pem";
	}
	else
	{
		$pushFileDirectory = "push_test_dir/ck.pem";
	}
	
	
	stream_context_set_option($ctx, 'ssl', 'local_cert', $pushFileDirectory);
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
	// Open a connection to the APNS server
	$fp = stream_socket_client
	(
		//'ssl://gateway.sandbox.push.apple.com:2195', $err,
		'ssl://gateway.push.apple.com:2195', $err,
		
		$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
	if (!$fp)
	{
		//exit("Failed to connect: $err $errstr" . PHP_EOL);
		$myFile = "testFile.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		$stringData = "Failed to connect: $err $errstr" . PHP_EOL;
		fwrite($fh, $stringData);
		fclose($fh);
		
	}
	
	//echo 'Connected to APNS' . PHP_EOL;
	
	// Create the payload body
	$body['aps'] = array
	(
		'alert' => $message,
		'sound' => 'default'
		
	);
	$body['userId'] = array
	(
		'fromUserId' =>$fromUserId
	);
	$body['userName'] = array
	(
		'fromUserName' =>$fromUserName
	);
	
	
	// Encode the payload as JSON
	$payload = $json->encode($body);
	
	// Build the binary notification
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
	// Send it to the server
	$result = fwrite($fp, $msg, strlen($msg));
	
	if (!$result)
	{
		//echo 'Message not delivered' . PHP_EOL;
		$myFile = "testFile.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		$stringData = "notificatin not sent\n";
		fwrite($fh, $stringData);
		fclose($fh);
		
	}
	
	else
	{
		//echo 'Message successfully delivered' . PHP_EOL;
		$myFile = "testFile.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		$stringData = "notificatin sent\n";
		fwrite($fh, $stringData);
		fclose($fh);
		
	}
	
	// Close the connection to the server
	fclose($fp);
	


}
?>