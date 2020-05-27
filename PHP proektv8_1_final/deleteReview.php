<?php
    if(isset($_POST['deleteReview']))
    {
        $id = $_POST['deletedId'];
        $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
        $check_query = "SELECT * FROM reviewrating WHERE reviewId = '$id';";
        $result = mysqli_query($db, $check_query);
        if(mysqli_num_rows($result)>0)
        {
            $query1 = "DELETE FROM reviewrating WHERE reviewId = '$id';";
            mysqli_query($db, $query1);
        }
        $query2 = "DELETE FROM review WHERE Id = '$id';";
        mysqli_query($db, $query2);
    }
?>