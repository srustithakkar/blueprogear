<?php
include("include/venue.php");

if($_GET['action']=="userlist")
{
	global $DAO;	
	$page = $_GET['page'];
	$limit = $page*5;
	$where =  "WHERE `user_type`=3 AND `is_delete` = 0";
	$orderby =  "ORDER BY `user_id` DESC LIMIT ".$limit.",5";
	$sql_user_list = "SELECT firstname, lastname, email, created_datetime FROM `user` $where $orderby";
	
	$result_user_list = $DAO->select($sql_user_list);
	echo json_encode($result_user_list);
	die;
}

if($_GET['action']=="venuevisited")
{
	global $DAO;	
	$page = $_GET['page'];
	$limit = $page*5;
	
	$where =  " WHERE u.`user_type`=3 AND v.`is_delete` = 0 AND uvv.status=1";
	$orderby =  " ORDER BY uvv.`id` DESC LIMIT ".$limit.",5";
	$sql = "SELECT 
					 u.`firstname`, 
					 u.`lastname`, 
					 v.`name`, 
					 date_format(uvv.`create_on`,'%m/%d/%Y') creatdate	 
				FROM 
					 `user_venue_visited` uvv
				INNER JOIN venue v ON uvv.venue_id=v.venue_id
				INNER JOIN  user u ON uvv.user_id=u.user_id
						$where $orderby";
	$result_venue = $DAO->select($sql);
	
	echo json_encode($result_venue);
	die;
}

if($_GET['action']=="venueregister")
{
	global $DAO;	
	$page = $_GET['page'];
	$limit = $page*5;
	
	$where =  "WHERE `is_delete` = 0";
	$orderby =  "ORDER BY `venue_id` DESC LIMIT ".$limit.",5";
	$sql = "SELECT `name`,DATE_FORMAT(`created_datetime`,'%m-%d-%Y') AS DATE FROM `venue` $where $orderby";
	$result_venuelisting = $DAO->select($sql);
	
	echo json_encode($result_venuelisting);
	die;
}

if($_GET['action']=="venueexpiries")
{
	global $DAO;	
	$page = $_GET['page'];
	$limit = $page*5;
	
	
	
	
	$sql_payment = "select v.name,DATE_FORMAT(`end`,'%m-%d-%Y') AS end FROM venue v INNER JOIN (SELECT venue_id,max(end) AS end FROM payments GROUP BY venue_id order by id DESC) p  ON v.venue_id=p.venue_id ORDER BY v.name LIMIT ".$limit.",5";
	$result_payment = $DAO->select($sql_payment);
	
	
	/*
	$sql = "SELECT v.`name`, p.`end` FROM `payments` p INNER JOIN `venue` v ON p.`venue_id` = v.`venue_id` 
				GROUP BY p.`venue_id` ORDER BY p.`id` DESC LIMIT ".$limit.",5";
	
	$result_payment = $DAO->select($sql);
	 * 
	 */
	
	echo json_encode($result_payment);
	die;
}

	
	
?>