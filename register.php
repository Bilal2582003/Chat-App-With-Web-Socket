<?php
$error = '';
$success = '';

if (isset($_POST['register'])) {
    session_start();
    if (isset($_SESSION['user_data'])) {
        header("location:chatroom.php");
    }

    require_once "database/User.php";
    $user_obj = new Users();
    $user_obj->setUserName($_POST['user_name']);
    $user_obj->setUserEmail($_POST['user_email']);
    $user_obj->setUserPassword($_POST['user_password']);
    $user_obj->setUserProfile($user_obj->make_avatar(strtoupper($_POST['user_name'][0])));
    $user_obj->setUserStatus('Disabled');
    $user_obj->setUserCreatedOn(date("Y-m-d H:i:s"));
    $user_obj->setUserVerificationCode(md5(uniqid()));
    $user_data = $user_obj->get_user_data_by_email();
    if (is_array($user_data) && count($user_data) > 0) {
        $error = "This Email is Already Register";
    } else {
        if ($user_obj->save_data()) {
            $success = 'Registeration Complete';
        } else {
            $error = "Something went wrong.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <br><br><br>
        <h1 class="text-center">Chat App With WebSocket</h1>
            <div class="row justify-content-md-center">
                <div class="col col-md-4 mt-5">
                    <?php
                    if ($error != '') {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ' . $error . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span arai-hidden="true">&times;</span>
                        </button>
                    </div>';
                    }
                    if ($success != '') {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ' . $success . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span arai-hidden="true">&times;</span>
                        </button>
                    </div>';
                    }
                    ?>

                    <div class="card">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <form action="" method="post" id="register_form">
                                <div class="form-group">
                                    <label for="">Enter Your Name</label>
                                    <input type="text" name="user_name" id="user_name" class="form-control"
                                        data-parsley-pattern="/^[a-zA-Z\s]+$/" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Enter Your Email</label>
                                    <input type="email" name="user_email" id="user_email" class="form-control" data-parsley-type="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Enter Your Password</label>
                                    <input type="password" name="user_password" id="user_password" class="form-control"
                                        data-parsley-minlength="6" data-parsley-maxlength="12"
                                        data-parsley-pattern="/^[a-zA-Z0-9]+$/" required>
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" value="Register" name="register" class="btn btn-success">
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
       
    </div>


    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/js/parsley.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#register_form").parsley();
        })
    </script>

</body>

</html>