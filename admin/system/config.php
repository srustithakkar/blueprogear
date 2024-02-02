<?php
 

require_once("db-config.php");
require_once("common_functions.php");


if($_SERVER['SERVER_NAME']=="localhost"){

	/* do not change here xxxxxxxxxxx */

	define('DB_HOST','localhost');
	define('DB_USER','blueprogear');
	define('DB_PASS','blueprogear');
	define('DB_NAME','blueprogear');
	define('ROOT_PATH','http://localhost/projects/bluepro/code/admin/');
	
	define('UPLOAD_PATH','http://localhost/projects/bluepro/code/admin/uploads/');
	
}else{

	/* change here with database new live credentials */

	error_reporting(1);
	define('DB_HOST','mysql.hostinger.in');
	define('DB_USER','u993134792_blue'); // database username
	define('DB_PASS','Admin@2701'); // database password
	define('DB_NAME','u993134792_live'); // database name
	define('ROOT_PATH','http://blueprogear.com/admin/'); 
      define('UPLOAD_PATH','http://blueprogear.com/admin/uploads/');


	
}

define('SITE_NAME','BluePro');
define('ADMIN_EMAIL','admin@bluepro.com');
define('DELETE_CONFIRM_MESSAGE','Are you sure you want to delete?'); 
define('ERROR_MESSAGE_CLASS','alert alert-danger');
define('SUCCESS_MESSAGE_CLASS','alert alert-success');

require_once("messages.php");
require_once("email-templates.php");

$DAO = new DAO(DB_HOST,DB_USER,DB_PASS,DB_NAME);

/* session */
session_start();

if (isset($_SESSION['browser_last_activity']) && (time() - $_SESSION['browser_last_activity'] > 6000000)) {
    // request 30 minates ago
    // set the logout time here
    header("Location: logout.php");		
}

$_SESSION['browser_last_activity'] = time();
/*
if(isset($_SESSION['user'])){
    $_SESSION['user_permission'] = getpermissionuserid($_SESSION['user']['user_id']);
}*/

/*
if(count($_SESSION['user'])>0){
    $inactive = 600;
    if(isset($_SESSION['timeout'])){
        $session_life = time() - $_SESSION['timeout'];
        if($session_life > $inactive){
             session_destroy(); header("Location: index.php?msg=6"); 
        }
    }
    $_SESSION['timeout'] = time();
}else{
    
}*/
 


?>