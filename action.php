<?php
session_start();
if(isset($_POST['action']) && $_POST['action'] == 'leave'){
   require_once "database/User.php";
   $user_obj = new Users();
   $user_obj->setUserId($_POST['user_id']);
   $user_obj->setUserLoginStatus("Logout");
   if($user_obj->update_user_login_data()){
    unset($_SESSION['user_data']);
    session_destroy();
    echo json_encode(["status"=>1]);
   } 
}

?>