<?php
require('connect.php');
$mailErr = $nameErr = $passwordErr = $confirmErr = $phoneErr = $addressErr = "";
$mail = $name = $password = $password_confirm = $phone = $address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["mail"])) {
    $mailErr = "Mail is required!!!";
  } else {
    $mail = test_input($_POST["mail"]);
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && "/^(\w+@\gmail)(\.\w{2,}){0,255}$/i") {
      $mailErr = "Invalid email format!!!";
    }
  }

  if (empty($_POST["name"])) {
    $nameErr = "Name is required!!!";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z]{6,200}$/", $name)) {
      $nameErr = "Error format!!!";
    }
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required!!!";
  } else {
    $password = test_input($_POST["password"]);
    if (!preg_match("/^[a-zA-Z0-9]{6,100}$/", $password)) {
      $passwordErr = "Error format!!!";
    }
  }

  if (empty($_POST["password_confirm"])) {
    $confirmErr = "Password-confirm is required!!!";
  } else {
    $password_confirm = test_input($_POST["password_confirm"]);
    if ($password_confirm != $password) {
      $confirmErr = "Not similar password input!!!";
    }
  }

  if (empty($_POST["address"])) {
    $addressErr = "Gender is required!!!";
  } else {
    $address = test_input($_POST["address"]);
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "Gender is required!!!";
  } else {
    $phone = test_input($_POST["phone"]);
    $pattern = "/^[0-9]{10,20}$/i";
    if (!preg_match($pattern, $phone)) {
      $phoneErr = "Error format!!!";
    }
  }
  // Lấy dl
  if (isset($_POST["mail"]))
    $mail = $_POST["mail"];

  if (isset($_POST["name"]))
    $name = $_POST["name"];

  if (isset($_POST["password"]))
    $password = $_POST["password"];

  if (isset($_POST["address"]))
    $address = $_POST["address"];

  if (isset($_POST["phone"]))
    $phone = $_POST["phone"];
  $updated_at = date('Y-m-d H:s:i');
  $created_at = $updated_at;

  //Xử lý lưu dl vào db
  $sql = "select * from `trangg`.`users` where email = '$mail'";
  $user = executeQuery($sql, false);
  if (!empty($_POST["mail"])) {
    if ($user) {
      $mailErr = "Mail đã tồn tại";
    } else {
      if (!empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["password_confirm"]) && !empty($_POST["address"]) && !empty($_POST["phone"])) {
        $insertQuery = "INSERT INTO `trangg`.`users`(`email`,`name`,`password`,`phone`,`address`,`created_at`,`updated_at`)
                                        VALUES('$mail','$name','$password','$phone','$address','$created_at','$updated_at')";
        $connect = getDBConnect();
        $stmt = $connect->prepare($insertQuery);
        $stmt->execute();
        header("Location: LoginPdo.php");
      }
    }
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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
  <title>Register form</title>
  <style>
    span {
      color: red;
      font-weight: 500;
    }

    label {
      font-weight: 500;
    }
  </style>
</head>

<body>
  <div class="form-register" style="background-color: #e9e9eb;">
    <div class="container">
      <div class="text-center">
        <h3 class="display-4">Register for Users</h3>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-left:300px;">
          <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="mail">Mail</label>
              <input type="text" name="mail" id="mail" class="form-control" placeholder="Enter your mail" value="<?php echo $mail; ?>">
              <span class="error"><?php echo $mailErr; ?></span>
            </div>
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" value="<?php echo $name; ?>">
              <span class="error"><?php echo $nameErr; ?></span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" value="<?php echo $password; ?>">
              <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <div class="form-group">
              <label for="password_confirm">Password_confirm</label>
              <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirm Password" value="<?php echo $password_confirm; ?>">
              <span class="error"><?php echo $confirmErr; ?></span>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" name="address" id="address" class="form-control" placeholder="Enter your address" value="<?php echo $address; ?>">
              <span class="error"><?php echo $addressErr; ?></span>
            </div>
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter your phone" value="<?php echo $phone; ?>">
              <span class="error"><?php echo $phoneErr; ?></span>
            </div>
            <input type="submit" class="btn btn-outline-danger" value="Register" style="margin-bottom: 135px;">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>