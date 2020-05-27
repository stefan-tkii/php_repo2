<?php
    if(isset($_GET['subtton']))
    {
        $gameId = $_GET['hidId'];
        session_start();
        $user = $_SESSION['username'];
        $pageName = "Game reviews";
        include("navbar.php");
    }
?>