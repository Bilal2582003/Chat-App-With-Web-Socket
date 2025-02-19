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
                $user_obj = new Users();
                $user_obj->setUserId($login_user_id);
                $user_data = $user_obj->get_all_user_data_with_status_count();


                ?>
                <div class="list-group" style="max-height:100vh;margin-bottom:10px;overflow-y:scroll;-webkit-overflow-scrolling:touch"></div>
                    <?php
                    foreach($user_data as $key => $value){
                        $icon = '<i class="fa fa-circle text-danger"></i>';
                        if($value['status'] == 'Login'){
                            $icon = '<i class="fa fa-circle text-success"></i>';
                        }
                        if($login_user_id != $value['id']){
                            if($value['count_status'] > 0){
                                $total_unread_message = '<span class="badge badge-danger badge-pill">'.$value['count_status'].'</span>';
                            }else{
                                $total_unread_message = '';
                            }
                            echo '<a class="list-group-item list-group-item-action select-user p-2" style="cursor:pointer" data-userid="'.$value['id'].'">
                            <img src="'.$value['profile'].'" class="image-fluid rounded-circle img-thumbnail" width="50" />
                            <span class="ml-1">
                            <strong>
                            <span id="list_user_name_'.$value['id'].'">'.$value['name'].'</span>
                            <span id="userid_'.$value['id'].'">'.$total_unread_message.'</span>
                            </strong>
                            </span>
                            <span class="mt-2 float-end mr-2" id="userstatus_'.$value['id'].'">'.$icon.'</span>
                             </a>';
                        }
                    }
                    ?>
                
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-7">
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