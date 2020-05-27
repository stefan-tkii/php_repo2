<?php

if(isset($_POST['send']))
{
    require_once('PHPMailer/PHPMailerAutoload.php');
    session_start();
    try 
    {
        $userMail = mb_convert_encoding($_SESSION['email'], 'UTF-8', 'UTF-8');
        $userMail = htmlentities($userMail, ENT_QUOTES, 'UTF-8');
        $server = $_POST['server'];
        $subject = mb_convert_encoding($_POST['subject'], 'UTF-8', 'UTF-8');
        $subject = htmlentities($subject, ENT_QUOTES, 'UTF-8');
        $pass = mb_convert_encoding($_POST['pass'], 'UTF-8', 'UTF-8');
        $pass = htmlentities($pass, ENT_QUOTES, 'UTF-8');
        $msg = mb_convert_encoding($_POST['message'], 'UTF-8', 'UTF-8');
        $msg = htmlentities($msg, ENT_QUOTES, 'UTF-8');
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = $server;
        $mail->Port = 465;
        $mail->Username = $userMail;
        $mail->Password = $pass;
        $mail->setFrom($userMail);
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->isHTML(false);
        $mail->addAddress('hypertextprepstefan@gmail.com');
        $mail->send();
        echo("<script> alert('Mail succsessfully sent!');window.location='Homepage.php'</script>");
    }
    catch(phpmailerException $e)
    {
        echo("<script> alert('$e');window.location='Homepage.php'</script>"); 
    }
    catch(Exception $e)
    {
        echo("<script> alert('$e');window.location='Homepage.php'</script>");  
    }

}

?>