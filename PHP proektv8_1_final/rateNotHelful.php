<?php
    if(isset($_POST['nothelpsub']))
    {
        $id = $_POST['ratingId'];
        $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
        $quer = "UPDATE reviewrating
        SET helpful = 0
        WHERE Id = '$id';";
        mysqli_query($db, $quer);
    }
?>