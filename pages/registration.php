<?php
session_start();
if (isset($_SESSION["user"])) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Styles/register.css">
  <link rel="stylesheet" href="../Styles/header.css">
  <title>Registration Form</title>
</head>

<body>
  <?php include('header.php'); ?>
  <div class="container">
    <div class="sign-header">
      <header>Sign-up</header>
    </div>
    <?php
    if (isset($_POST["submit"])) {
      $username = $_POST["username"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $passwordRepeat = $_POST["repeat_password"];

      $errors = array();

      if (empty($username) or empty($email) or empty($password) or empty($passwordRepeat)) {
        array_push($errors, "All fields are required");
      }

      if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
      }
      if ($password !== $passwordRepeat) {
        array_push($errors, "Password does not match");
      }
      require_once "database.php";
      $sql = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);
      $rowCount = mysqli_num_rows($result);
      if ($rowCount > 0) {
        array_push($errors, "Email already exists!");
      }

      if (count($errors) > 0) {
        foreach ($errors as  $error) {
          echo "<div class='alert-danger'>$error</div>";
        }
      } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email,	password_hash) VALUES ( ?, ?, ? )";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
          mysqli_stmt_execute($stmt);
          echo "<div class='alert-success'>You are registered successfully.</div>";
        } else {
          die("Something went wrong");
        }
      }
    }
    ?>

    <form action="registration.php" method="post">
      <div class="sign-box">
        <div class="input-box">
          <input type="text" class="input-field" name="username" placeholder="Username:">
        </div>
        <div class="input-box">
          <input type="email" class="input-field" name="email" placeholder="Email:">
        </div>
        <div class="input-box">
          <input type="password" class="input-field" name="password" placeholder="Password:">
        </div>
        <div class="input-box">
          <input type="password" class="input-field" name="repeat_password" placeholder="Repeat Password:">
        </div>
        <div class="input-submit">
          <input type="submit" class="submit-btn" value="Register" name="submit">
          <label for="submit">Register</label>
        </div>
        <div class="sign-up-p">
          <p class="sign-up-p">Already Registered <a href="login.php">Login Here</a></p>
        </div>
      </div>
    </form>
  </div>

</body>

</html>