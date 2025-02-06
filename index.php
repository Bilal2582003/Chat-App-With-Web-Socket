<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Chat Application</title>
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
                    ?>
                </div>
            </div>
        
    </div>
    
</body>
</html>