<?php
session_start();
if (isset($_SESSION['user_data'])) {
    header("locaiton:index.php");
}
require_once "database/User.php";
$user_obj = new Users();
$user_id = '';
foreach ($_SESSION['user_data'] as $key => $value) {
    $user_id = $value['id'];
}
$user_obj->setUserId($user_id);
$user_data = $user_obj->get_user_data_by_id();
if (!is_array($user_data) || count($user_data) <= 0) {
    $user_data = array();
}
$message = '';
if (isset($_POST['edit'])) {
    $user_profile = $_POST['hidden_profile'];
    if ($_FILES['user_profile']['name'] != '') {
        $user_profile = $user_obj->upload_image($_FILES['user_profile']);
        $_SESSION['user_data'][$user_id]['profile'] = $user_profile;

        $user_obj->setUserName($_POST['user_name']);
        $user_obj->setUserEmail($_POST['user_email']);
        $user_obj->setUserPassword($_POST['user_password']);
        $user_obj->setUserProfile($user_profile);
        $user_obj->setUserId($user_id);
        if ($user_obj->update_data()) {
            $message = '<div class="alert alert-success">Profile Detail Updated</div>';
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFILE || PHP Chat Application</title>
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <br><br>
        <h1 class="text-center">Profile || Chat Application with Web socket</h1>
        <?php echo $message; ?>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Profile
                    </div>
                    <div class="col-md-6" style="text-align:right"><a href="chatroom.php" class="btn btn-warning btn-sm">Go to
                            Chat</a>
                        </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" id="profile-form">
                    <div class="form-group">
                        <label for="">Enter Your Name</label>
                        <input type="text" name="user_name" id="user_name" class="form-control"
                            data-parsley-pattern="/^[a-zA-Z\s]+$/" value="<?php echo $user_data['name'] ?>" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="">Enter Your Email</label>
                        <input type="email" name="user_email" id="user_email" class="form-control"
                            value="<?php echo $user_data['email'] ?>" data-parsley-type="email" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="">Enter Your Password</label>
                        <input type="password" name="user_password" id="user_password" class="form-control"
                            value="<?php echo $user_data['password'] ?>" data-parsley-minlength="6"
                            data-parsley-maxlength="12" data-parsley-pattern="/^[a-zA-Z0-9]+$/" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="">Profile</label><br>
                        <input type="file" name="user_profile" id="user_profile">
                        <br>
                        <img src="<?php echo $user_data['profile']; ?>" class="image-fluid image-thumbnail mt-3"
                            width="100">
                        <input type="hidden" name="hidden_profile" value="<?php echo $user_data['profile'] ?>">
                    </div>
                    <br>
                    <div class="form-group text-center">
                        <input type="submit" name="edit" class="btn btn-primary" style="min-width: 20%;" value="Edit">
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script src="src/js/parsley.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#login_form").parsley();
        })
    </script>
</body>

</html>