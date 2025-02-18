<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header("location:index.php");
}
require "database/User.php";
require "database/Chatroom.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private ChatRoom || PHP Chat Application</title>
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/css/font-awesome.min.css">
    <link rel="stylesheet" href="src/css/parsley.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-5">
                <div style="background-color:#f1f1f1;height:100vh;border-right:1px solid #ccc">
                    <?php
                    $login_user_id = '';
                    foreach ($_SESSION['user_data'] as $key => $value) {
                        $login_user_id = $value['id'];
                   ?>
                    <div class="mt-3 mb-3 text-center"><img src="<?php echo $value['profile'] ?>" alt=""
                            class="img-fluid img-thumbnail rounded-circle" width="150">
                            <h3 class="mt-2"><?php echo $value['name'];?></h3>
                            <a href="profile.php" class="btn btn-secondary mt-2 mb-2">Edit</a>

                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
            <div class="col-lg-9 col-md-8div sm-7">
                <br>
                <h3 class="text-center">Real time one to one chat By retchat websocket</h3>
                </br>
            </div>
        </div>
    </div>




    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/js/parsley.min.js"></script>
    <script src="src/js/font-awesome.min.js"></script>
</body>

</html>