<?php
    $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
    include('./Models/UserGame.php');
    include('./Models/userGameGenres.php');
    require_once('PHPMailer/PHPMailerAutoload.php');
    $pic = $_GET['picture'];
    unlink($pic);
    $gameId = $_GET['hido1'];
    $userM = $_GET['emailo1'];
    $server = "smtp.gmail.com";
    $query = "DELETE FROM usergame_genres WHERE usergameId = '$gameId';";
    mysqli_query($db, $query);
    $newq = "DELETE FROM usergame WHERE `Id` = '$gameId';";
    mysqli_query($db, $newq);
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = $server;
    $mail->Port = 465;
    $mail->Username = 'hypertextprepstefan@gmail.com';
    $mail->Password = 'Nikolakiskosarakis1!';
    $mail->setFrom('hypertextprepstefan@gmail.com');
    $mail->Subject = "Feedback regarding your game submission.";
    $mail->Body = "We hereby inform you that your submission has been rejected. Have a nice day!";
    $mail->isHTML(false);
    $mail->addAddress($userM);
    $mail->send();
    echo("<script> alert('Game has been rejected!');window.location='Homepage.php'</script>");
?>