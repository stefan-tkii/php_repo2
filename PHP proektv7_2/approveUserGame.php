<?php
    include('./Models/Game.php');
    include('./Models/userGameGenres.php');
    require_once('PHPMailer/PHPMailerAutoload.php');
    $gameId = $_GET['hido2'];
    $userM = $_GET['emailo2'];
    $server = "smtp.gmail.com";
    $pic = $_GET['picture'];
    $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
    $query = "SELECT * FROM usergame WHERE `Id` = '$gameId' LIMIT 1;";
    $game = new game();
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $game->Id = $gameId;
            $game->name = $row['name'];
            $game->compNames = $row['compNames'];
            $game->platforms = $row['platforms'];
            $game->releaseDate = $row['releaseDate'];
        }
    }
    $name_modified = str_replace(' ', '', $game->name);
    $name_remodified = preg_replace('/[^A-Za-z0-9\-]/', '', $name_modified);
    $str_arr1 = explode(".", $pic);
    $newDest = "Assets/admin_" . $name_remodified . "." . end($str_arr1);
    rename($pic, $newDest); 
    $query1 = "SELECT * FROM usergame_genres WHERE usergameId = '$gameId';";
    $ggenres = array();
    $res = mysqli_query($db, $query1);
    if(mysqli_num_rows($res)>0)
    {
        while($row = mysqli_fetch_assoc($res))
        {
            $ugenres = new userGameGenres();
            $ugenres->Id = $row['Id'];
            $ugenres->userGameId = $gameId;
            $ugenres->genreId = $row['genreId'];
            array_push($ggenres, $ugenres);
        }
    }
    $insertGame = "INSERT INTO game (`name`, compNames, platforms, releaseDate, adminId) VALUES ('$game->name', '$game->compNames', '$game->platforms', '$game->releaseDate', 1);";
    mysqli_query($db, $insertGame);
    $REGET = "SELECT `Id` FROM game WHERE `name` = '$game->name';";
    $newres = mysqli_query($db, $REGET);
    $id = '';
    if(mysqli_num_rows($newres)>0)
    {
        while($row = mysqli_fetch_assoc($newres))
        {
            $id = $row['Id'];
        }
    }
    foreach($ggenres as $gnr)
    {
        $inQuery = "INSERT INTO game_genres (gameId, genreId) VALUES ('$id', '$gnr->genreId');";
        mysqli_query($db, $inQuery);
    }
    $deleteUgame = "DELETE FROM usergame WHERE `Id` = '$gameId';";
    foreach($ggenres as $gnr)
    {
        $deleteUgenres = "DELETE FROM usergame_genres WHERE `Id` = '$gnr->Id';";
        mysqli_query($db, $deleteUgenres);
    }
    mysqli_query($db, $deleteUgame);
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
    $mail->Body = "We hereby inform you that your submission has been accepted. Thank you for the submission!";
    $mail->isHTML(false);
    $mail->addAddress($userM);
    $mail->send();
    echo("<script> alert('Game has been approved!');window.location='Homepage.php'</script>");
?>