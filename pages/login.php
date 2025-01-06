<?php
session_start();
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        echo "Email and Password are required.";
    } else {
        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user && password_verify($password, $user["password_hash"])) {
                $_SESSION["user"] = [
                    "email" => $user["email"],
                    "role" => $user["role"]
                ];
                if ($user["role"] === "admin") {
                    echo "success-admin";
                } else {
                    echo "success-user";
                }
            } else {
                echo "Incorrect email or password";
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
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
    <title>Login Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").on("submit", function(event) {
                event.preventDefault();
                var email = $("input[name='email']").val();
                var password = $("input[name='password']").val();
                $.ajax({
                    url: "login.php",
                    type: "POST",
                    data: {
                        login: true,
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        console.log(response);
                        if (response === "success-admin") {
                            window.location.href = "dashboard/addproducts.php";
                        } else if (response === "success-user") {
                            window.location.href = "index.php";
                        } else {
                            $(".alert-danger").html(response).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(status, error);
                        $(".alert-danger").html("An error occurred. Please try again.").show();
                    }
                });
            });
        });
    </script>
</head>

<body>
    <?php include 'header.php' ?>
    <div class="container">
        <div class="login-header">
            <header>Login</header>
        </div>
        <form action="login.php" method="post">
            <div class="login-box">
                <div class="input-box">
                    <input type="email" placeholder="Enter Email:" name="email" class="input-field" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Enter Password:" name="password" class="input-field" required>
                </div>
                <div class="input-submit">
                    <input type="submit" value="Login" name="login" class="submit-btn">
                    <label for="submit">LOGIN</label>
                </div>
                <div class="sign-up-p">
                    <p>Not registered yet? <a href="registration.php">Register Here</a></p>
                </div>
            </div>
        </form>
        <div class="alert-danger" style="display:none; color: red;"></div>
    </div>
</body>

</html>