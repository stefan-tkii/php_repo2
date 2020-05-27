<?php

    if(isset($_POST['subce']))
    {
        $name = mb_convert_encoding($_POST['game_name'], 'UTF-8', 'UTF-8');
        $name = htmlentities($name, ENT_QUOTES, 'UTF-8');
        $name_esc = mysqli_real_escape_string($db, $name);
        $comp = mb_convert_encoding($_POST['game_comp'], 'UTF-8', 'UTF-8');
        $comp = htmlentities($comp, ENT_QUOTES, 'UTF-8');
        $comp_esc = mysqli_real_escape_string($db, $comp);
        $plat = mb_convert_encoding($_POST['game_platforms'], 'UTF-8', 'UTF-8');
        $plat = htmlentities($plat, ENT_QUOTES, 'UTF-8');
        $plat_esc = mysqli_real_escape_string($db, $plat);
        $date = $_POST['game_date'];
        $errs = array();

        $img = $_FILES['game_image'];
        $img_name = $img['name'];
        $img_tmp_name = $img['tmp_name'];
        $img_size = $img['size'];
        $img_error = $img['error'];
        $img_type = $img['type'];

        if($img_error != 0)
        { array_push($errs, $img_error); }

        if($img_size > 500000) #0.5 MB, 500kB
        { array_push($errs, "File size is too big."); }

        $img_ext = explode('.', $img_name);
        $ext = strtolower(end($img_ext));
        $allowed = array('jpg', 'jpeg', 'png');

        if(!(in_array($ext, $allowed)))
        { array_push($errs, "Unallowed file type. Only jpg, jpeg and png are supported."); }
      
        $gnrs = array();
        foreach($_POST['selected'] as $sel)
        {
            array_push($gnrs, $sel);
        }

        if(count($errs)==0)
        {
            if(!(isset($_SESSION['admin']))) #ako sme logirani kako korisnik
            {
            $name_modified = str_replace(' ', '', $name);
            $name_remodified = preg_replace('/[^A-Za-z0-9\-]/', '', $name_modified);
            $fileNew = $_SESSION['id'] . "_" . $name_remodified . "." . $ext;
            $id = $_SESSION['id'];
            $fileDest = "Uploads/" . $fileNew;
            move_uploaded_file($img_tmp_name, $fileDest);
            $query_insert_game = "INSERT INTO usergame (`name`, compNames, platforms, releaseDate, isApproved, userId, adminId) VALUES ('$name_esc', '$comp_esc', '$plat_esc', '$date', 0, '$id', 1);";
            mysqli_query($db, $query_insert_game);
            $query_get = "SELECT `Id` FROM usergame WHERE `name` = '$name_esc' AND userId = '$id' LIMIT 1;";
            $rs = mysqli_query($db, $query_get);
            if(mysqli_num_rows($rs)>0)
            {
                while($row = mysqli_fetch_assoc($rs))
                {
                    $game_id = $row['Id'];
                    foreach($gnrs as $gr)
                    {
                        $query_genre = "INSERT INTO usergame_genres (usergameId, genreId) VALUES ('$game_id', '$gr');";
                        mysqli_query($db, $query_genre);
                    }
                }
            }
            echo("<script> alert('Succsessfully submitted.');window.location='Homepage.php'</script>");
            }
            else #ako sme logirani kako administrator
            {
                $name_modified = str_replace(' ', '', $name);
                $name_remodified = preg_replace('/[^A-Za-z0-9\-]/', '', $name_modified);
                $fileNew = "admin" . "_" . $name_remodified . "." . $ext;
                $fileDest = "Assets/" . $fileNew;
                move_uploaded_file($img_tmp_name, $fileDest);
                $query_insert_game = "INSERT INTO game (`name`, compNames, platforms, releaseDate, adminId) VALUES ('$name_esc', '$comp_esc', '$plat_esc', '$date', 1);";
                mysqli_query($db, $query_insert_game);
                $query_get = "SELECT `Id` FROM game WHERE `name` = '$name_esc' LIMIT 1;";
                $rs = mysqli_query($db, $query_get);
                if(mysqli_num_rows($rs)>0)
                {
                    while($row = mysqli_fetch_assoc($rs))
                    {
                        $game_id = $row['Id'];
                        foreach($gnrs as $gr)
                        {
                            $query_genre = "INSERT INTO game_genres (gameId, genreId) VALUES ('$game_id', '$gr');";
                            mysqli_query($db, $query_genre);
                        }
                    }
                }
                echo("<script> alert('Succsessfully submitted (admin).');window.location='Homepage.php'</script>");
            }
        }
    }
    
?>