<?php

class product {

    function __construct() {
        $this->table_name = 'user';
    }

    function managerlist() {
        global $DAO;
        $sql = "SELECT * FROM `user` where user_type=2 AND is_delete=0";
        $result = $DAO->select($sql);
        return $result;
    }

    function managervenuelist() {
        global $DAO;
        $sql = "SELECT u.*,v.name FROM `user` u LEFT JOIN venue v ON u.user_id = v.manager_id where u.user_type=2 AND u.is_delete=0";
        $result = $DAO->select($sql);
        return $result;
    }

    function subadminlist() {
        global $DAO;
        $sql = "SELECT * FROM `user` where user_type=4 AND is_delete=0";
        $result = $DAO->select($sql);
        return $result;
    }

    function submanagerlist() {
        global $DAO;
        if ($_SESSION['user']['user_type'] == 1 or $_SESSION['user']['user_type'] == 4) {
            $sql = "SELECT * FROM `user` where user_type=5 AND is_delete=0";
            $result = $DAO->select($sql);
            $i = 0;
            foreach ($result as $value) {
                $sql = "SELECT firstname,lastname FROM `user` where user_id=" . $value['parent_user_id'];
                $res = $DAO->select($sql);
                $result[$i] = $value;
                $result[$i]['managername'] = $res[0]['firstname'] . ' ' . $res[0]['lastname'];
                $i++;
            }
        } else {
            $sql = "SELECT * FROM `user` where user_type=5 AND is_delete=0 AND parent_user_id=" . $_SESSION['user']['user_id'];
            $result = $DAO->select($sql);
        }
        return $result;
    }

    function productlist($id='') {
        global $DAO;
        
        $str='';
        
        if($id){
        	$str=' AND p.id='.$id;
        }
        
        $sql = "SELECT * FROM `mst_product` p 
				where p.is_delete='0' ".$str." ";
        $result = $DAO->select($sql);

        return $result;
    }

    function userlist() {
        global $DAO;
        $sql = "SELECT u.*,temp.venue_id,temp.create_on as venuelasttime,v.name as venuelastname FROM `user` u 
                LEFT JOIN (SELECT t.* FROM  user_venue_visited t
                            JOIN 
                                ( SELECT user_id, max(create_on) date
                                          FROM user_venue_visited GROUP BY user_id
                                ) t2
                                ON t.create_on = t2.date AND t.user_id = t2.user_id group by user_id) temp ON temp.user_id=u.user_id
                                
                LEFT JOIN venue v ON temp.venue_id = v.venue_id                
                where u.user_type=3 AND u.is_delete=0";
        $result = $DAO->select($sql);
        return $result;
    }

    function ethinicitylist() {
        global $DAO;
        $sql = "SELECT * FROM `ethinicity`";
        $result = $DAO->select($sql);
        return $result;
    }

    function manageridnamelist() {
        global $DAO;
        $sql = "SELECT user_id,firstname,lastname FROM `user` where user_type=2 AND is_delete=0 order by firstname";
        $result = $DAO->select($sql);
        return $result;
    }

  

    function add($description,$title, $imagefilename) {

        global $DAO;
        $photo = $imagefilename;

        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `mst_product` (`description`,`title`,`photo`,`created_datetime`) VALUES
										('" . $description . "','" . $title . "','" . $photo . "','" . $now . "')";

        $q = $DAO->query($sql);
       
        if ($q) {
            /* global $welcome_email;
              $welcome_email = str_replace("[#USER_NAME#]", $firstname." ".$lastname, $welcome_email);
              $welcome_email = str_replace("[#EMAIL#]",$email, $welcome_email);
              $subject = SITE_NAME.' - Registration';
              $result = send_mail(ADMIN_EMAIL,$email,$subject,$welcome_email); */

            return true;
        } else {
            return false;
        }
    }
    
    function updateProduct($description,$title, $imagefilename,$id) {

        global $DAO;
        
        $photostr='';
        
        if($imagefilename!=''){
        	$photostr=", `photo`='".$imagefilename."'";
        }
        
        

        $now = date('Y-m-d H:i:s');

        $sql = "update `mst_product` 
        	set `description` = '".$description."',
        		`title`='".$title."' $photostr
        		
        	Where id = '".$id."'";

        $q = $DAO->query($sql);
       
        if ($q) {
            /* global $welcome_email;
              $welcome_email = str_replace("[#USER_NAME#]", $firstname." ".$lastname, $welcome_email);
              $welcome_email = str_replace("[#EMAIL#]",$email, $welcome_email);
              $subject = SITE_NAME.' - Registration';
              $result = send_mail(ADMIN_EMAIL,$email,$subject,$welcome_email); */

            return true;
        } else {
            return false;
        }
    }

    function manageradd($firstname, $lastname, $email, $contact_no, $password, $imagefilename, $usertype) {

        global $DAO;
        $photo = $imagefilename;
        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `user` (`firstname`,`lastname`,`email`,`contact_no`,`password`,`photo`,`user_type`,`created_datetime`) VALUES
										('" . $firstname . "','" . $lastname . "','" . $email . "','" . $contact_no . "','" . $password . "','" . $photo . "',$usertype,'" . $now . "')";
        $q = $DAO->insertquery($sql);
        if ($q['STATUS']) {

            $user_id = $q['RESULT']['inserted_id'];
            $permission = array();
            $permission['user_id'] = $user_id;
            $permission['venue'] = serialize(array("add" => 1, "edit" => 1, "view" => 1, "delete" => 1, "suspend" => 1));
            $permission['manager'] = serialize(array("add" => 0, "edit" => 0, "view" => 0, "delete" => 0, "suspend" => 0));
            $permission['user'] = serialize(array("add" => 0, "edit" => 0, "view" => 0, "delete" => 0, "suspend" => 0));
            $permission['category'] = serialize(array("add" => 0, "edit" => 0, "view" => 0, "delete" => 0, "suspend" => 0));
            $permission['package'] = serialize(array("add" => 0, "edit" => 0, "view" => 1, "delete" => 0, "suspend" => 0));
            $permission['report'] = serialize(array("add" => 1, "edit" => 1, "view" => 1, "delete" => 1, "suspend" => 1));
            $permission['offer_of_venue'] = serialize(array("add" => 1, "edit" => 1, "view" => 1, "delete" => 1, "suspend" => 1));
            $permission['notification'] = serialize(array("add" => 0, "edit" => 0, "view" => 0, "delete" => 0, "suspend" => 0));
            $permission['discount'] = serialize(array("add" => 0, "edit" => 0, "view" => 0, "delete" => 0, "suspend" => 0));
            $permission['venueemployee'] = serialize(array("add" => 1, "edit" => 1, "view" => 1, "delete" => 1, "suspend" => 1));
            $permission['ethinicity'] = serialize(array("add" => 0, "edit" => 0, "view" => 0, "delete" => 0, "suspend" => 0));
            $this->permissiontableinsert($permission);


            global $welcome_email;
            $welcome_email = str_replace("[#USER_NAME#]", $firstname . " " . $lastname, $welcome_email);
            $welcome_email = str_replace("[#EMAIL#]", $email, $welcome_email);
            $subject = SITE_NAME . ' - Registration';
            $result = send_mail(ADMIN_EMAIL, $email, $subject, $welcome_email);
        }
        return $q;
    }

    function employeeadd($firstname, $lastname, $email, $contact_no, $password, $imagefilename, $usertype, $parent_user_id) {

        global $DAO;
        $photo = $imagefilename;
        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `user` (`firstname`,`lastname`,`email`,`contact_no`,`password`,`photo`,`user_type`,`created_datetime`,`parent_user_id`) VALUES
										('" . $firstname . "','" . $lastname . "','" . $email . "','" . $contact_no . "','" . $password . "','" . $photo . "',$usertype,'" . $now . "','$parent_user_id')";
        $q = $DAO->insertquery($sql);
        if ($q['STATUS']) {
            global $welcome_email;
            $welcome_email = str_replace("[#USER_NAME#]", $firstname . " " . $lastname, $welcome_email);
            $welcome_email = str_replace("[#EMAIL#]", $email, $welcome_email);
            $subject = SITE_NAME . ' - Registration';
            $result = send_mail(ADMIN_EMAIL, $email, $subject, $welcome_email);
        }
        return $q;
    }

    function permissiontableinsert($data) {
        global $DAO;
        $result = $DAO->insert('user_permission', $data);
    }

    function permissiontabledelete($user_id) {
        global $DAO;
        $result = $DAO->query("Delete from user_permission where user_id='$user_id'");
    }

    function emailcheck($email) {
        global $DAO;
        $email = addslashes(trim($email));
        $sql = "SELECT * FROM `user` WHERE `email` = '" . $email . "' AND is_delete=0";
        $query = $DAO->select($sql);
        if (count($query) > 0) {
            return false;
        } else {
            return true;
        }
    }

    function editmanger($firstname, $lastname, $email, $contact_no, $user_id, $imagefilename) {
        global $DAO;
        $photo = $imagefilename;

        $sql = "UPDATE `user` SET 
					`firstname` = '" . $firstname . "',
					`lastname` = '" . $lastname . "',
					`contact_no` = '" . $contact_no . "',
					`photo` = '" . $photo . "' 
		   		  WHERE 
					`user_id` = '" . $user_id . "'";

        $q = $DAO->query($sql);
        return true;
    }

    function editvenueemployee($firstname, $lastname, $email, $contact_no, $user_id, $imagefilename, $parent_user_id) {
        global $DAO;
        $photo = $imagefilename;

        $sql = "UPDATE `user` SET 
					`firstname` = '" . $firstname . "',
					`lastname` = '" . $lastname . "',
					`contact_no` = '" . $contact_no . "',
					`photo` = '" . $photo . "',
					`parent_user_id` = '" . $parent_user_id . "'  
		   		  WHERE 
					`user_id` = '" . $user_id . "'";

        $q = $DAO->query($sql);
        return true;
    }

    function edituser($firstname, $lastname, $email, $dob, $gender, $contact_no, $user_id, $imagefilename, $ethinicity) {
        global $DAO;
        $photo = $imagefilename;

        $sql = "UPDATE `user` SET 
					`firstname` = '" . $firstname . "',
					`lastname` = '" . $lastname . "',
					`dob` = '" . $dob . "',
					`gender` = " . $gender . ",
					`contact_no` = '" . $contact_no . "',
					`photo` = '" . $photo . "',
					`ethinicity` = '" . $ethinicity . "' 
		   		  WHERE 
					`user_id` = '" . $user_id . "'";
        $q = $DAO->query($sql);
        return true;
    }

    function Pdel($pid) {
        global $DAO;
        $photo = $imagefilename;

        $sql = "UPDATE `mst_product` SET 
					`is_delete` = '1' 
		   		  WHERE 
					`id` = '" . $pid . "'";
        $q = $DAO->query($sql);
        return true;
    }

    function delete() {
        global $DAO;

        $sql = "SELECT firstname,lastname,user_type FROM `user` WHERE `user_id`='" . $_REQUEST['delete_user'] . "'";
        $result = $DAO->select($sql);

        if (count($result) > 0) {
            $data = array('is_delete' => 1);
            $where = array('user_id' => $_REQUEST['delete_user']);
            $q = $DAO->update('user', $data, $where);
            if ($result[0]['user_type'] == 2) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deleted manager '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);

                $sql = "SELECT venue_id,manager_id FROM `venue` WHERE `manager_id`='" . $_REQUEST['delete_user'] . "'";
                $result = $DAO->select($sql);
                foreach ($result as $value) {
                    $data = array('is_delete' => 1);
                    $where = array('venue_id' => $value['venue_id']);
                    $q = $DAO->update('venue', $data, $where);
                    $q = $DAO->update('offers', $data, $where);
                }
            }
            if ($result[0]['user_type'] == 5) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deleted venue employee '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 3) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deleted user '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 4) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deleted admin employee '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
        }
        return true;
        /*
          $sql = "DELETE FROM `user` WHERE `user_id`='".$_REQUEST['delete_user']."'";
          $q = $DAO->query($sql);
          return true;
         * 
         */
    }

    function deactivate($id) {
        global $DAO;
        $sql = "SELECT firstname,lastname,user_type FROM `user` WHERE `user_id`='" . $id . "'";
        $result = $DAO->select($sql);
        if (count($result) > 0) {
            $data = array('is_deactive' => 1);
            $where = array('user_id' => $id);
            $q = $DAO->update('user', $data, $where);

            if ($result[0]['user_type'] == 2) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deactivate manager '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 3) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deactivate user '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 4) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deactivate admin employee '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 5) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Deactivate venue employee '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
        }
        return true;
    }

    function activate($id) {
        global $DAO;
        $sql = "SELECT firstname,lastname,user_type FROM `user` WHERE `user_id`='" . $id . "'";
        $result = $DAO->select($sql);
        if (count($result) > 0) {
            $data = array('is_deactive' => 0);
            $where = array('user_id' => $id);
            $q = $DAO->update('user', $data, $where);

            if ($result[0]['user_type'] == 2) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Activate manager '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 3) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Activate user '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 4) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Activate admin employee '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
            if ($result[0]['user_type'] == 5) {
                $firstname = $result[0]['firstname'];
                $lastname = $result[0]['lastname'];

                $logmsg = "Activate venue employee '$firstname $lastname'";
                activitylog($_SESSION['user']['user_id'], $logmsg);
            }
        }
        return true;
    }

    function permissionsanitizeArray($inarr) {
        if (!is_array($inarr)) {
            $inarr = array();
        }
        if (empty($inarr["add"])) {
            $inarr["add"] = 0;
        }
        if (empty($inarr["edit"])) {
            $inarr["edit"] = 0;
        }
        if (empty($inarr["delete"])) {
            $inarr["delete"] = 0;
        }
        if (empty($inarr["view"])) {
            $inarr["view"] = 0;
        }
        if (empty($inarr["suspend"])) {
            $inarr["suspend"] = 0;
        }
        return (array) $inarr;
    }

    function vdd($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit();
    }

    function login($username, $password, $access_token) {
        //vdd($password);
        global $DAO;
        $array = array();

        $sql = "SELECT * FROM `user` WHERE `email`='" . $username . "' AND is_delete=0";
        $result = $DAO->select($sql);
        if (count($result) > 0) {

            if ($result[0]['user_type'] != 3 and $result[0]['is_deactive'] == 0) {
                $now = date('Y-m-d H:i:s');
                $descrypted_password = pass_decrypt($result[0]['password']);
                if ($password == $descrypted_password) {
                    $sql = "UPDATE `user` SET `access_token`='" . $access_token . "', `lastlogin_datetime`= '$now' WHERE `user_id`=" . $result[0]['user_id'];
                    $DAO->query($sql);
                    $array['message'] = "Login successfully.";
                    $array['user'] = $result[0];
                    $array['user']['access_token'] = $access_token;


                    $timelogmanage = array();
                    $timelogmanage['user_id'] = $result[0]['user_id'];
                    $timelogmanage['login'] = date('Y-m-d H:i:s');
                    $timelogmanage['date'] = date('Y-m-d');
                    $DAO->insert('timelog_manage', $timelogmanage);
                } else {
                    $array['error'] = "true";
                    $array['message'] = "Wrong username or passowrd";
                }
            } else {

                if ($result[0]['is_deactive']) {
                    $array['error_suspend'] = "true";
                }
                $array['error'] = "true";
            }
        } else {
            $array['error'] = "true";
            $array['message'] = "User does not exist";
        }
        return $array;
    }

    function userdetailbyid($id) {
        global $DAO;
        $sql = "SELECT * FROM `user` WHERE `user_id`=$id";
        $result = $DAO->select($sql);
        $permission = $this->getpermissionuserid($id);
        $result['permission'] = $permission;
        return $result;
    }

    function getpermissionuserid($id) {
        global $DAO;
        $sql = "SELECT * FROM `user_permission` WHERE `user_id`=$id";
        $result = $DAO->select($sql);
        $therole = array();

        if (count($result) > 0) {
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
        }
        return $therole;
    }

    public function forgotPassword($email) {

        global $DAO;
        $sql = "SELECT * FROM `user` WHERE `email`='" . $email . "' AND is_delete=0";
        $user_details = $DAO->select($sql);
        if (count($user_details) > 0) {

            if ($user_details[0]['is_delete'] == 1) {
                $resultArray['STATUS'] = 0;
                $resultArray['MESSAGE'] = "User is deleted please contact site owner.";
            } else {
                $activationtoken = uniqid('', true);
                $sql = "UPDATE `user` SET `password_token`='" . $activationtoken . "' WHERE `user_id`='" . $user_details[0]['user_id'] . "' AND is_delete=0";
                $DAO->query($sql);
                $resultArray = $this->sendForgotPasswordEmail($user_details, $activationtoken);
            }
        } else {
            $resultArray['STATUS'] = 0;
            $resultArray['MESSAGE'] = "User with '" . $email . "' does not exist";
        }

        return $resultArray;
    }

    public function sendForgotPasswordEmail($user, $activationtoken) {

        global $DAO, $forgot_password_email;

        $forgot_password_email = str_replace("[#USER_NAME#]", $user[0]['firstname'], $forgot_password_email);
        $forgot_password_email = str_replace("[#REST_LINK#]", ROOT_PATH . 'change-password.php?token=' . $activationtoken, $forgot_password_email);

        $forgot_password_email = str_replace("[#EMAIL#]", $user[0]['email'], $forgot_password_email);

        $subject = SITE_NAME . ' - Reset Your Password';
        $result = send_mail(ADMIN_EMAIL, $user[0]['email'], $subject, $forgot_password_email);
        if ($result) {
            $resultArray['STATUS'] = 1;
            $resultArray['MESSAGE'] = USER_RESET_PASSWORD_EMAIL_SUCCESS;
        } else {
            $resultArray['STATUS'] = 0;
            $resultArray['MESSAGE'] = USER_EMAIL_ERROR;
        }
        return $resultArray;
    }

    public function requestpassword($userid) {

        global $DAO;
        $sql = "SELECT * FROM `user` WHERE `user_id`='" . $userid . "' AND is_delete=0";
        $user_details = $DAO->select($sql);
        if (count($user_details) > 0) {

            if ($user_details[0]['is_delete'] == 1) {
                $resultArray['STATUS'] = 0;
                $resultArray['MESSAGE'] = "User is deleted please contact site owner.";
            } else {
                $activationtoken = uniqid('', true);
                $sql = "UPDATE `user` SET `password_token`='" . $activationtoken . "' WHERE `user_id`='" . $user_details[0]['user_id'] . "' AND is_delete=0";
                $DAO->query($sql);
                $resultArray = $this->requestpasswordemail($user_details, $activationtoken);
            }
        } else {
            $resultArray['STATUS'] = 0;
            $resultArray['MESSAGE'] = "User with '" . $email . "' does not exist";
        }

        return $resultArray;
    }

    public function requestpasswordemail($user, $activationtoken) {

        global $DAO, $request_password_email;
        $request_password_email = str_replace("[#USER_NAME#]", $user[0]['firstname'], $request_password_email);
        $request_password_email = str_replace("[#REST_LINK#]", ROOT_PATH . 'change-password.php?token=' . $activationtoken, $request_password_email);
        $request_password_email = str_replace("[#EMAIL#]", $user[0]['email'], $request_password_email);
        $request_password_email = str_replace("[#PASSWORD#]", base64_decode($user[0]['password']), $request_password_email);
        $subject = SITE_NAME . ' - Account Detail';

        $result = send_mail(ADMIN_EMAIL, $user[0]['email'], $subject, $request_password_email);
        return true;
    }

    function userdetailbytoken($token) {
        global $DAO;
        $sql = "SELECT * FROM `user` WHERE `password_token`='$token'";
        $result = $DAO->select($sql);
        return $result;
    }

    public function sendPasswordChangedEmail($user, $activationtoken) {
        global $DAO, $update_password_email;

        $from = ADMIN_EMAIL;
        $to = $user['email'];

        $subject = SITE_NAME . ' - Password Updated Successfully';

        $update_password_email = str_replace("[#USER_NAME#]", $user['firstname'], $update_password_email);
        $update_password_email = str_replace("[#REST_LINK#]", ROOT_PATH . 'change-password.php?token=' . $activationtoken, $update_password_email);

        $result = send_mail($from, $to, $subject, $update_password_email);
        if ($result) {
            $resultArray['STATUS'] = 1;
            $resultArray['MESSAGE'] = "Password Updated Successfully";
        } else {
            $resultArray['STATUS'] = 0;
            //$resultArray['MESSAGE'] = USER_EMAIL_ERROR;
        }
        return $resultArray;
    }

    function changePassword($userid, $password) {
        global $DAO;

        $activationtoken = uniqid('', true);
        $sql = "UPDATE `user` SET `password`='" . $password . "',`password_token`='" . $activationtoken . "' WHERE `user_id`='" . $userid . "'";
        $DAO->query($sql);

        $sql = "SELECT * FROM `user` WHERE `user_id`='$userid'";
        $result_user = $DAO->select($sql);

        $this->sendPasswordChangedEmail($result_user[0], $activationtoken);

        /*
          $logmsg = "Profile password change";
          activitylog($_SESSION['user']['user_id'],$logmsg);
         */

        return true;
    }

}

?>