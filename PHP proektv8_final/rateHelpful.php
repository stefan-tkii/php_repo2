<?php
    if(isset($_POST['helpsub']))
    {
        $id = $_POST['ratingId'];
        $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
        $quer = "UPDATE reviewrating
        SET helpful = 1
        WHERE Id = '$id';";
        mysqli_query($db, $quer);
    }
?>