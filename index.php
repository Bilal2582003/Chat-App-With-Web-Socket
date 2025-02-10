<?php
session_start();
$error = '';
if(isset($_SESSION['user_data'])){
    header("location:chatroom.php");
}

if(isset($_POST['login'])){
 require_once "database/User.php";
 $user_obj = new Users();
 $user_obj->setUserEmail($_POST['user_email']);
 $user_data = $user_obj->get_user_data_by_email();
 if(is_array($user_data) && count($user_data) > 0){

    if($user_data['status'] == 'Enabled'){
        if($user_data['password'] == $_POST['user_password']){
            $user_obj->setUserId($user_data['id']);
            $user_obj->setUserLoginStatus('Login');
            if($user_obj->update_user_login_data()){
             $_SESSION['user_data'][$user_data['user_id']] = [
                "id"=>$user_data['user_id'],
                "name"=>$user_data['name'],
                "profile"=>$user_data['profile']
             ];  
             header("location:chatroom.php"); 
            }else{

            }
        }else{
            $error = 'Wrong Password';
        }
    }else{
        $error = 'Please verify your Email Address.';
    }

 }else{
    $error = "Wrong Email Address!";
 }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN || PHP Chat Application</title>
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <br><br>
        <h1 class="text-center">PHP Applicaton with Web Socket</h1>
            <div class="row justify-content-md-center mt-5">
                <div class="col-md-4">
                    <?php
                    if(isset($_SESSION['success_message'])){
                        echo '<div class="alert alert-success">'.$_SESSION['success_message'].'</div>';
                        unset($_SESSION['success_message']);
                    }
                    if($error != ''){
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                    ?>

                    <di class="card">
                        <div class="card-header">
                            Login
                        </div>
                            <div class=" card-body">
                                <form action="" method="post" id="login_form">
                                    <div class="form-group">
                                        <label for="">Enter Your Email</label>
                                    <input type="text" name="user_email" class="form-control" id="user_email" data-parsley-type="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Enter Password</label>
                                    <input type="text" name="user_password" class="form-control" id="user_password" required>
                                    </div>
                                    <div class="form-group text-center">
                                       
                                    <input type="submit" name="login" class="btn btn-primary" id="login" value="Login" required>
                                    </div>
                                </form>
                            </div>
                    </di>

                </div>
            </div>
        
    </div>
    <script>
        $(document).ready(function () {
            $("#login_form").parsley();
        })
    </script>
</body>
</html>