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
    <link rel="stylesheet" href="src/css/font-awesome.min.css">
</head>
<style>
    #message_area {
        min-width: 90%;
        height: 50vh;
        background-color: lightgray;
    }

    #chat_message,
    #send {
        min-height: 60px;
    }
</style>

<body>
    <div class="container">
        <br><br>
        <h1 class="text-center">PHP CHAT APPLICATION USING WEB SOCKET</h1>
        <div class="row justify-content-md-center mt-5">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3>
                            CHAT ROOM
                        </h3>
                    </div>
                    <dvi class="card-body" id="message_area"></dvi>
                </div>
                <form method="post" id="chat_form">
                    <div class="input-group mb-3">
                        <textarea name="chat_message" id="chat_massage" class="form-control"
                            placeholder="Type Message Here" data-parsley-maxlength="1000" data="/^[a-zA-Z1-09\s]+$/"
                            required></textarea>
                        <div class="input-group-append">
                            <button type="submit" name="send" id="send" class="btn btn-primary">
                                <i class="fa-regular fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <div class="validation_error"></div>
                </form>
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
                        <input type="button" value="Logout" class="btn btn-danger mt-2 mb-2" name="logout" id="logout">
                    </div>

                    <?php
                }
                ?>
            </div>

        </div>
    </div>
    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/js/parsley.min.js"></script>
    <script src="src/js/font-awesome.min.js"></script>
    <script>
        $(document).ready(function () {

            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function (e) {
                console.log("Connection established!");
            };

            conn.onmessage = function (e) {
                console.log(e)
                var data = JSON.parse(e.data);
                console.log(data)
                var row = '';
                var background_color = '';
                if (data.from == 'Me') {
                    row = 'row justify-content-end';
                    background_color = 'text-dark alert-light';
                } else {
                    row = 'row justify-content-start';
                    background_color = 'alert-success';
                }

                var html_data = `<div class="${row}">
                                    <div class="col-sm-10">
                                        <div class="shadow-sm alert ${background_color}">
                                            <b>${data.from}</b>
                                            ${data.msg} 
                                            <br>
                                            <div class="text-end">
                                                <small> <i> ${data.dt} </i> </small> 
                                            </div> 
                                        </div> 
                                    </div>
                                 </div>`;
                $("#message_area").append(html_data);
                $("#chat_massage").val('');
            };
            $("#chat_form").parsley();
            $("#chat_form").on("submit", function (event) {
                event.preventDefault();
                if ($("#chat_form").parsley().isValid()) {
                    var user_id = $("#login_user_id").val();
                    var message = $("#chat_massage").val();
                    var data = {
                        userId: user_id,
                        msg: message
                    }
                    conn.send(JSON.stringify(data));
                }
            })
            $("#logout").on("click", function () {
                var user_id = $("#login_user_id").val();
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: { user_id: user_id, action: 'leave' },
                    success: function (data) {
                        var response = JSON.parse(data)
                        if (response.status == 1) {
                            location = "index.php";
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>