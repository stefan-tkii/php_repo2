<?php
    if(isset($_GET['publish']))
    {
        $reviewFor = $_GET['hido01'];
        $reviewBy = $_GET['hido02'];
        $reviewForName = $_GET['hido03'];
        $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
        $contents = mb_convert_encoding($_GET['review_contents'], 'UTF-8', 'UTF-8');
        $contents = htmlentities($contents, ENT_QUOTES, 'UTF-8');
        $contents_esc = mysqli_real_escape_string($db, $contents);
        $queryy = "INSERT INTO review (content, userId, gameId) VALUES ('$contents_esc', '$reviewBy', '$reviewFor');";
        mysqli_query($db, $queryy);
        $link = "listReviews.php?hidId=" . $reviewFor . "&hidName=" . $reviewForName . "&subtton=See+Reviews";
        header("location: " . $link);
    }
?>