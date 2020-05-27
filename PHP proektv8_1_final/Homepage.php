
<?php
    session_start();
    if(isset($_SESSION['succsess_login']))
    {
        $user = $_SESSION['username'];
    }
    else
    {
        header("location: Login.php");
    }
    $pageName = "Home page";
    include('navbar.php');
?>

