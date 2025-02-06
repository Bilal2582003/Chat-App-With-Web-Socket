<?php
$error ='';
session_start();
if(isset($_GET['code'])){
 require_once "database/User.php";
 $user_obj = new Users();
 $user_obj->setUserVerificationCode($_GET['code']);
 if($user_obj->is_valid_email_verification_code()){
    $user_obj->setUserStatus('Enabled');
    if($user_obj->enable_user_account()){
        $_SESSION['success_message'] = 'Your Email Successfully verify. now you can login into this chat Application';
        header("location:index.php");
    }else{
        $error = 'Something went wrong try agiain...';
    }
    
 }else{
    $error = 'Something went wrong try agiain...';
 }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email | Verify PHP Chat APP</title>
</head>
<body>
    
</body>
</html>