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
                foreach ($_SESSION['user_data'] as $key => $value) {      
                    ?>
                        <div class="mt-2 mb-3 text-center">
                            <img src="<?php echo $value['profile'] ?>" alt="error" width="150" class="img-fluid rounded-circle img-thumbnail">
                            <h3 class="mt-2"><?php echo $value['name'] ?></h3>
                            <a href="profile.php" class="btn btn-secondary mt-2 mb-2">Edit</a>
                        </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
</body>

</html>