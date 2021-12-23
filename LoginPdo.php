<?php
include('connect.php');
$mailErr = $passwordErr = "";
$mail = $password = "";

// Xử lý đăng nhập
session_start();
if (isset($_POST["submit"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["mail"])) {
            $mailErr = "Mail is required!!!";
        } else {
            $mail = $_POST["mail"];
            if (filter_var($mail, FILTER_VALIDATE_EMAIL) === false && "/^(\w+@\gmail)(\.\w{2,}){0,255}$/i") {
                $mailErr = "Invalid email format!!!";
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required!!!";
        } else {
            $password = $_POST["password"];
            if (!preg_match("/^[a-zA-Z0-9]{6,100}$/", $password)) {
                $passwordErr = "Error format!!!";
            }

            if (empty($mailErr) === true && empty($passwordErr) === true) {
                $a_check = ((isset($_POST["remember"]) != 0) ? 1 : "");
                $mail = strip_tags($mail);
                $mail = addslashes($mail);
                $password = strip_tags($password);
                $password = addslashes($password);

                $connect = getDBConnect();
                $sql = "select * from `trangg`.`users` where email = '$mail'";
                $user = executeQuery($sql, false);
                if ($user) {
                    // trước khi login thì phải logout tk trước đó   
                    session_destroy();
                    if ($user['password'] == $password) {
                        $_SESSION["mail"] = $data->mail;
                        header("Location: LoginSuccessPdo.php");
                        if ($a_check == 1) {
                            setcookie("mail", $_POST["mail"], time() + 86400);
                            setcookie("password", $_POST["password"], time() + 86400);
                        }
                    }
                }
                echo "Đăng nhập thất bại. Vui lòng nhập lại <a href='javascript: history.go(-1)'>Trở lại</a>";
                exit;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        span {
            color: red;
            font-weight: 500;
        }

        label {
            font-weight: 500;
        }
    </style>
    <title>Login</title>
</head>

<body>
    <div class="container login-container" style="background-color: #e9e9eb;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-left:300px; margin-top:100px;">
                <h3 class="display-4" style="margin-bottom:20px; text-align:center;">Login</h3>
                <form method="post" enctype="multipart/form-data" action="">
                    <div class="form-group">
                        <label for="mail">Mail :</label>
                        <input type="text" class="form-control" name="mail" placeholder="Your mail" value="<?= isset($_POST["mail"]) ? $_POST["mail"] : "" ?>" />
                        <span class="error"><?php echo $mailErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password :</label>
                        <input type="password" class="form-control" name="password" placeholder="Your Password" < />
                        <span class="error"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="form-group form-check">
                        <label class="form-check-label"><input class="form-check-input" type="checkbox" name="remember"> Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" style="margin-bottom:150px;">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>