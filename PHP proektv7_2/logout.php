<?php
    session_start();
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['succsess_login']);
    echo("<script> alert('You have been logged out!');window.location='Home.php'</script>");
?>