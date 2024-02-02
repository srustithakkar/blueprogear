<?php

function __autoload($class_name)
{
    $pfad = "./classes/class." . $class_name . ".php";
    if (file_exists($pfad))
    {
        require_once($pfad);
    }
    else
    {

        die("<b>Fatal Error. Class $class_name could not be located.</b>");
    }
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

//Check User Token
function checkUserToken(){
	
    global $DAO;
    
    $sql = "SELECT * FROM `user` WHERE `user_id`='".$_SESSION['user']['user_id']."'";
    $result = $DAO->select($sql);
	
	if($_SESSION['user']['access_token'] != $result['0']['access_token']){
        return true;
    }else{
        return true;
    }
}

function getpermissionuserid($id)
{
		global $DAO;
	    $sql = "SELECT * FROM `user_permission` WHERE `user_id`=$id";
	    $result = $DAO->select($sql);
	    $therole = array();
	    $therole["venue"] = unserialize($result[0]["venue"]);
        $therole["manager"] = unserialize($result[0]["manager"]);
        $therole["user"] = unserialize($result[0]["user"]);
        $therole["category"] = unserialize($result[0]["category"]);
        $therole["package"] = unserialize($result[0]["package"]);
        $therole["report"] = unserialize($result[0]["report"]);
        $therole["offer_of_venue"] = unserialize($result[0]["offer_of_venue"]);
        $therole["notification"] = unserialize($result[0]["notification"]);
        $therole["discount"] = unserialize($result[0]["discount"]);
        $therole["venueemployee"] = unserialize($result[0]["venueemployee"]);
		$therole["ethinicity"] = unserialize($result[0]["ethinicity"]);
        return $therole;
}

function activitylog($userid,$msg){
	
    global $DAO;
	//if($_SESSION['user']['user_type'] !=1)
	//{
		$activitylog = array();
		$activitylog['user_id'] = $userid;
	    $activitylog['message'] = addslashes($msg);
	    $activitylog['created'] = date('Y-m-d H:i:s');
		$result = $DAO->insert('activitylog',$activitylog);
	//}	
	return true;
    
}


//Check file exist or not
function checkFileExist($filePath){
	$result = file_exists($filePath);
	return $result;
}

//Get File extension from file name or file path
function getFileExtension($file_name){
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	return $ext;
}

//Replace null to empty string
function emptyString($str){
	if($str==""){
		$str = addslashes($str);
		$str = stripslashes($str);
	}
	return $str;
}

//Replace null to empty string
function inputString($str){
	$str = addslashes(trim($str));
	return $str;
}

function getArrayVal(array $array, $name)
{
    if (array_key_exists($name, $array))
    {
        return $array[$name];
    }
    else
    {
        return false;
    }
}
//function for uploading image
function imageUpload($string,$image_path){
	$img = str_replace('data:image/png;base64,', '', $string);
	//$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$success = file_put_contents($image_path, $data);
	return $success ? true : false;
}

//Function for Password Encryption
function pass_encrypt($string){

	$string = base64_encode($string);

	return $string;
}

//Function for Password Decryption
function pass_decrypt($string){
    
	/*$key = PASSWORD_ENCRYPTIO_KEY;
    $data = base64_decode($string);
	
    $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
    
	$decrypted = rtrim(
		mcrypt_decrypt(
			MCRYPT_RIJNDAEL_256,
			hash('sha256', $key, true),
			substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)),
			MCRYPT_MODE_CBC,
			$iv
		),
		"\0"
	);*/
	
	$string = base64_decode($string);

	return $string;
}

//User Image upload
function uploadUserImage($string){
	$image_name = mktime().".png";
	$image_path = USER_IMAGE_PATH.$image_name;
	$result = imageUpload($string,$image_path);
	return $image_name;
}

//Create Game Image
function createGameImage($string){
	$image_name = mktime().".png";
	$image_path = GAME_IMAGE_PATH.$image_name;
	$result = imageUpload($string,$image_path);
	return $image_name;
}

//Update Game Image
function updateGameImage($image_name,$string){
	$image_path = GAME_IMAGE_PATH.$image_name;
	$result = imageUpload($string,$image_path);
	return $image_name;
}

//Function for sending email
function send_mail($from,$to,$subject,$message){
			
		   require_once 'lib/php_mailer/PHPMailerAutoload.php';
		   
		   $from = 'test@sunshineinfotech.com';
		   $mail = new PHPMailer();
		   $mail->isSMTP();
		   $mail->SMTPDebug = 0;
		   $mail->Debugoutput = 'html';
		   $mail->Host = 'smtp.gmail.com';
		   $mail->Port = 465;
		   $mail->SMTPSecure = 'ssl';
		   $mail->SMTPAuth = true;
		   $mail->Username = $from;
		   $mail->Password = "Sunshine12345";
		   $mail->setFrom($from, 'Whozout');
		   $mail->addReplyTo($from);
		   $mail->addAddress($to);
		   $mail->Subject = $subject;
		   $mail->msgHTML($message);
		   if (!$mail->send())
		   {
		   		$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: whozout' . "\r\n";
				mail($to, $subject, $message, $headers);
			   $result = "Mailer Error: " . $mail->ErrorInfo;
		   }
		   else 
		   {	
			   $result =  "Message sent!";
		    }
		    return $result;
}

//Function for forgot password
function send_forgot_password_email($user){
	$subject = 'WhatApps - Forgot Password';
	$message = 'Hello '.$user[0]['first_name'].' '.$user[0]['last_name'].', <br/><br/>Your account details are as below:<br/><br/>
			Email ID : '.$user[0]['email_address'].'<br/>'
			.'Password : '.pass_decrypt($user[0]['password']).'<br/>';
	$from = ADMIN_EMAIL;
	$to = $user[0]['email_address'];
	$result = send_mail($from,$to,$subject,$message);
	return $result;
}


function customDateDiff($time,$ab,$ago){
    $string = '';
    
    $array = explode(" ",$time[0]);
    switch($array[1]){
        case 'years':
            $string = $array[0].' Year';
            break;
        case 'year':
            $string = $array[0].' Year';
            break;
        case 'month':
            $string = $array[0].' Month';
            break;
        case 'months':
            $string = $array[0].' Month';
            break;
        case 'day':
            if($array[0]>7){
                $string = floor($array[0]/7).' Week';
            }else{
                $string = $array[0].' Days';
            }
            break;
        case 'days':
            if($array[0]>7){
                $string = floor($array[0]/7).' Week';
            }else{
                $string = $array[0].' Days';
            }
            break;
        case 'hour':
            $string = $array[0].' Hour';
            break;
        case 'hours':
            $string = $array[0].' Hour';
            break;
        case 'minute':
            $string = $array[0].' Min';
            break;
        case 'minutes':
            $string = $array[0].' Min';
            break;
        case 'second':
            $string = $array[0].' Sec';
            break;
        case 'seconds':
            $string = $array[0].' Sec';
            break;
    }
    return $ab.$string.$ago;
  }
  
  
  
  
  function datediff($fromdate) {
    
    $currunttime = date('Y-m-d h:i A',mktime());
    
    $time1 = $fromdate;
    $time2 = $currunttime;
    $precision = 6;
    
    //echo $time1."########".$time2."<br/>";
    
    $date= $currunttime;
    $ab = " ";
    $ago = " ago";  
    if($time2 < $time1){
        $ab = "Starts in ";
        $ago = "";
    }
    
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
    if($time1 == $time2){
        return "1 sec ago";
    }
    
    
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }
 
      $time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
    break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
    // Add s if value is not 1
    if ($value != 1) {
      $interval .= "s";
    }
    // Add value and interval to times array
    $times[] = $value . " " . $interval;
    $count++;
      }
    }
 
    $string = customDateDiff($times,$ab,$ago);
    
    // Return string with times
    return $string;
  }
 
  
/*
* WEB SERVICE CALL FUNCTIONS
*/
function executeService($url,$parameter){
	//echo $url."<br/>";
	//print_r($parameter);
	$curl = curl_init($url);
	$curl_post_data = $parameter;
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	$response = curl_exec($curl);
	$info = curl_getinfo($curl);
	$error = curl_error($curl);
	curl_close($curl);
	$data = json_decode($response,true);
	
	return $data;
}


function pinimage($name,$frame,$destination)
{
	$width = 110;
	$height = 157;
	$layers = array();
	
	
	$layers[] = imagecreatefrompng($name);	
	$layers[] = imagecreatefrompng($frame);
	$image = imagecreatetruecolor($width, $height);
	imagealphablending($image, false);
	$transparency = imagecolorallocatealpha($image, 0, 0, 0, 127);
	imagefill($image, 0, 0, $transparency);
	imagesavealpha($image, true);
	imagealphablending($image, true);
	imagecopy($image, $layers[0], 20, 20, 0, 0, 75,75);
	imagecopy($image, $layers[1], 0, 0, 0, 0, $width, $height);
	imagealphablending($image, false);
	imagesavealpha($image, true);
	imagepng($image,$destination);
	
}

function pinimage_map($name,$frame,$destination)
{
	$width = 27;
	$height = 39;
	$layers = array();
	
	
	$layers[] = imagecreatefrompng($name);	
	$layers[] = imagecreatefrompng($frame);
	$image = imagecreatetruecolor($width, $height);
	imagealphablending($image, false);
	$transparency = imagecolorallocatealpha($image, 0, 0, 0, 127);
	imagefill($image, 0, 0, $transparency);
	imagesavealpha($image, true);
	imagealphablending($image, true);
	imagecopy($image, $layers[0], 5,5, 0, 0, 18,18);
	imagecopy($image, $layers[1], 0, 0, 0, 0, $width, $height);
	imagealphablending($image, false);
	imagesavealpha($image, true);
	imagepng($image,$destination);
	
}



?>