<?php
class dashboard 
{	
	function usermanager()
	{
		global $DAO;
		$where =  "WHERE `is_delete`=0";
		$sql = "SELECT SUM(CASE WHEN `user_type`='3' THEN 1 ELSE 0 END) AS `users` FROM `user` $where";		
		$result = $DAO->select($sql);
		return $result;	
	}
	
	
	function totalcheckout()
	{
		global $DAO;
		$sql = "SELECT count(*) AS `totalcheckout` FROM `user_venue_visited`";		
		$result = $DAO->select($sql);
		return $result;	
	}
	
	function venuelist()
	{
		global $DAO;
		$where =  "WHERE `is_delete`=0";
		$sql_venue = "SELECT COUNT(venue_id) AS venue FROM `venue` $where";
		$result_venue = $DAO->select($sql_venue);
		return $result_venue;	
	}
	
	function userlisting($limit)
	{
		global $DAO;
		$where =  "WHERE `user_type`=3 AND `is_delete` = 0";
		if($limit)
		{
			$orderby =  "ORDER BY `user_id` DESC LIMIT 5";
		}
		else
		{
			$orderby =  "ORDER BY `user_id` DESC";
		}		
		$sql_user_list = "SELECT firstname, lastname, email, created_datetime FROM `user` $where $orderby";
		
		$result_user_list = $DAO->select($sql_user_list);
		return $result_user_list;	
	}
	
	function venuevisited($limit)
	{
		global $DAO;
		$where =  " WHERE u.`user_type`=3 AND v.`is_delete` = 0 AND uvv.status=1";
		
		if($limit)
		{
			$orderby =  " ORDER BY uvv.`id` DESC LIMIT 5";
		}
		else
		{
			$orderby =  " ORDER BY uvv.`id` DESC";
		}	
		$sql_user_list = "SELECT 
								 u.`firstname`, 
								 u.`lastname`, 
								 v.`name`, 
								 uvv.`create_on` 	 
							FROM 
								 `user_venue_visited` uvv
							INNER JOIN venue v ON uvv.venue_id=v.venue_id
							INNER JOIN  user u ON uvv.user_id=u.user_id
							$where $orderby";
							
							
		$result_venue = $DAO->select($sql_user_list);
		return $result_venue;	
	}
	
	function venuelisting($limit)
	{
		global $DAO;
		$where =  "WHERE `is_delete` = 0";
		if($limit)
		{
			$orderby =  "ORDER BY `venue_id` DESC LIMIT 5";
		}
		else
		{
			$orderby =  "ORDER BY `venue_id` DESC";
		}	
		
		$sql_user_list = "SELECT `name`,`created_datetime` FROM `venue` $where $orderby";
		$result_venuelisting = $DAO->select($sql_user_list);
		return $result_venuelisting;	
	}
	
	function paymentlisting($limit)
	{
		global $DAO;
				
		if($limit)
		{
			$orderby =  " ORDER BY v.name LIMIT 5";
		}
		else
		{
			$orderby =  " ORDER BY v.name";
		}	
				
				
		
		/*
		$sql = "SELECT v.`name`, p.`end` 
			FROM 
				`payments` p INNER JOIN `venue` v ON p.`venue_id` = v.`venue_id` 
				GROUP BY p.`venue_id` $orderby";*/
		
		$sql_payment = "select v.name,p.end,pt.end as temp_expiries,pt.subscription_id as temp_subscription FROM venue v 
						LEFT JOIN (SELECT venue_id,max(end) AS end FROM payments GROUP BY venue_id order by id DESC) p  ON v.venue_id=p.venue_id 
						LEFT JOIN payments_temp pt on pt.venue_id = v.venue_id
						$orderby";
		$result_payment = $DAO->select($sql_payment);
		return $result_payment;	
	}
}

?>
