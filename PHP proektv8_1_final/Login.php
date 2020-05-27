<?php include('login_logic.php') ?>

<?php
    if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
    {
        $usern = $_COOKIE['username'];
        $passn = $_COOKIE['password'];
        echo "<script>
        document.getElementById('username').value = '$usern';
        document.getElementById('password').value ='$passn';
        </script>";
    }
?>
<!DOCTYPE html>

<head>
    <title>Login page</title>
    <link rel = "stylesheet" type = "text/css" href = "asset.css"/>
</head>

<body class="boddie">
    <div class="container">
        <img src="Assets/avatar.png" class="login_avatar">
        <h1 class="headr">Please fill the form to log in</h1>
        <form action="Login.php" method="POST">

        <?php if(isset($_POST['Login'])) : ?>
                <?php include('login_errors.php') ?>
        <?php endif ?>
            <br>

            <label class="para">Username:</label>
            <input maxlength="25" required class="txttype" type="text" id="username" name="username" placeholder="Enter username">

            <label class="para">Password:</label>
            <input maxlength="50" required class="txttype" type="password" id="password" name="password" placeholder="Enter password">

            <label class="para">Remember me</label>
            <input type="checkbox" name="remember"> <br>

            <p class="para">Don't have an account? <a class="linke" href="Register.php">Register here</a></p> <hr>

            <input class="btntype" type="submit" name="Login" value="Login">

        </form>

    </div>
</body>