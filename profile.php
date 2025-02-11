<?php
session_start();
if (isset($_SESSION['user_data'])) {
    header("locaiton:index.php");
}
require_once "database/User.php";
$user_obj = new Users();
$user_id = '';
foreach($_SESSION['user_data'] as $key => $value){
    $user_id = $value['id'];
}
$user_obj->setUserId($user_id);
$user_data = $user_obj->get_user_data_by_id();
if(is_array($user_data) && count($user_data) > 0){

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
        <h1 class="text-center">CHAT ROOM</h1>
        <div class="row">`
            <div class="col-md-6">
                Profile
            </div>
                <div class="col-md-6 text-right"></div>

        </div>
    </div>


    <script>
        $(document).ready(function () {
            $("#login_form").parsley();
        })
    </script>
</body>

</html>