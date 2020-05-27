<?php
    if(isset($_POST['Login']))
    {
        $username = '';
        $pass = '';
        $email='';
        $errors = array();
        $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
        $username = mb_convert_encoding($_POST['username'], 'UTF-8', 'UTF-8');
        $username = htmlentities($username, ENT_QUOTES, 'UTF-8');
        $username_escaped = mysqli_real_escape_string($db, $username);
        $pass = mb_convert_encoding($_POST['password'], 'UTF-8', 'UTF-8');
        $pass = htmlentities($pass, ENT_QUOTES, 'UTF-8');
        $pass_escaped = mysqli_real_escape_string($db, $pass);
        $hashed_pass = md5($pass_escaped);

        if(empty($username)) { array_push($errors, 'Username field is empty!.');}
        if(empty($pass)) { array_push($errors, 'Password field is empty!');}


        $check_query = "SELECT `password` FROM `admin` WHERE username = '$username_escaped';";
        $result = mysqli_query($db, $check_query);
        if(mysqli_num_rows($result)>0)
        {
            $admin = true;
            while($row = mysqli_fetch_assoc($result)) 
            {
                if(!($row['password'] == $pass))
                {
                    array_push($errors, "Incorrect password.");
                }
            }
        }
        else
        {
            array_push($errors, "Incorrect username.");
        }

        if(mysqli_num_rows($result) == 0)
        {
            $admin = false;
            $errors = array();
            $check_query = "SELECT `password` FROM user WHERE username = '$username_escaped';";
            $result = mysqli_query($db, $check_query);
            if(mysqli_num_rows($result)>0)
                {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        if(!($row['password'] == $hashed_pass))
                        { array_push($errors, "Incorrect password."); }
                    }
                }
            else
                { array_push($errors, "Incorrect username."); }
        }
        
        if(count($errors)==0)
        {
            if($admin == false) 
            {
            if(isset($_POST['remember']))
            {
                setcookie('username', $username_escaped, time()+60*60*7);
                setcookie('password', $pass_escaped, time()+60*60*7);
            }
            session_start();
            $query = "SELECT * FROM user WHERE username = '$username_escaped'";
            $res = mysqli_query($db, $query);
            if(mysqli_num_rows($res)>0)
            {
                while($row = mysqli_fetch_assoc($res)) { $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['Id']; }
            }
            $_SESSION['username'] = $username_escaped;
            $_SESSION['succsess_login'] = "You have succsessfully logged in.";
            unset($_SESSION['logout']);
            header("location: Homepage.php");
            }
            else
            {
                session_start();
                $_SESSION['username'] = $username_escaped;
                $_SESSION['succsess_login'] = "You have succsessfully logged in.";
                $_SESSION['admin'] = "admin";
                unset($_SESSION['logout']);
                header("location: Homepage.php");
            }
        }
    }
?>