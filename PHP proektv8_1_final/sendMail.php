
<?php
    session_start();
    $user = $_SESSION['username'];
    include('send.php');
    $pageName = "Send mail";
    include("navbar.php");
    if(!(isset($_SESSION['succsess_login'])))
    { header("location: Login.php"); }
?>



<!DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="styling.css"/>
    </head>

    <body>
        
        <div class="contact-title">
            <h1 style="color: white">Send us a mail</h1>
        </div>

        <div class="contact-form">
            <form class="inside-form" method="post" action="sendMail.php">
                <label class="placelabel-input" for="subject">Subject:</label> <br>
                <input required maxlength="40" name="subject" type="text" class="form-control" placeholder="Enter the subject"><br>

                <label class="placelabel-input-pass" for="pass">Email password:</label> <br>
                <input required maxlength="60" name="pass" type="password" class="form-control" placeholder="Enter your email password "><br>

                <label class="placelabel" for="email">Email server:</label> <br> <br>
                <input required checked type="radio" class="radio" name="server" value="smtp.gmail.com" id="x" />
                <label class="placelabel" for="x">Gmail |</label>
                <input type="radio" class="radio" name="server" value="smtp.live.com" id="y" />
                <label class="placelabel" for="y">Outlook |</label>
                <input type="radio" class="radio" name="server" value="smtp.mail.yahoo.com" id="z" />
                <label class="placelabel" for="z">Yahoo</label>
                <br>

                <textarea name="message"  class="form-control-message" rows="10" required maxlength="500" placeholder="Type your message here"></textarea> <br>

                <input type="submit" class="form-control-submit" value="Send" name="send"> 


            </form>
        </div>
  

    </body>