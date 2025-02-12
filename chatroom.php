<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHATROOM || PHP Chat Application</title>
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <br><br>
        <h1 class="text-center">CHAT ROOM</h1>
        <div class="row justify-content-md-center mt-5">
            <div class="col-lg-8">
            </div>
            <div class="col-lg-4">
                <?php
                $login_user_id = '';
                foreach ($_SESSION['user_data'] as $key => $value) {
                    $login_user_id = $value['id'];
                    ?>
                    <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>"
                        value="<?php echo $login_user_id; ?>">
                    <div class="mt-2 mb-3 text-center">
                        <img src="<?php echo $value['profile'] ?>" alt="error" width="150"
                            class="img-fluid rounded-circle img-thumbnail">
                        <h3 class="mt-2"><?php echo $value['name'] ?></h3>
                        <a href="profile.php" class="btn btn-secondary mt-2 mb-2">Edit</a>

                    </div>
                    <input type="button" value="Logout" class="btn btn-danger mt-2 mb-2" name="logout" id="logout">
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
    <script>
        $(dcoument).ready(function () {
            $("#logout").on("click", function () {
                var user_id = $("#login_user_id").val();
                window.location.assign("logout.php");
            })
        })
    </script>
</body>

</html>