<?php 
    session_start();
    $userEmail = "";
    include('./Models/UserGame.php');
    include('./Models/userGameGenres.php');
    include('./Models/genre.php');
    $user = $_SESSION['username'];
     if(!(isset($_SESSION['admin'])))
     { header("location: Login.php"); }
     $pageName = "Entries list";
     include("navbar.php");
     $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
     $query = "SELECT * FROM usergame;";
     $games = array();
     $result = mysqli_query($db, $query);
     if(mysqli_num_rows($result)>0)
     {
         while($row = mysqli_fetch_assoc($result))
         {
             $ugame = new userGame();
             $ugame->Id = $row['Id'];
             $ugame->name = $row['name'];
             $ugame->compNames = $row['compNames'];
             $ugame->platforms = $row['platforms'];
             $ugame->releaseDate = $row['releaseDate'];
             $ugame->isApproved = $row['isApproved'];
             $ugame->userId = $row['userId'];
             $ugame->adminId = $row['adminId'];
             array_push($games, $ugame);
         }
     }
?>


<!DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="entrylist.css"/>
    </head>

<body>

<h1 class="subtitle">List of entries awaiting approval: </h1>

<?php if(count($games)==0) : ?>
    <h2 class="subtitle">No entries found.</h2>
<?php endif ?>

<div class="main_cont">
     <?php if(count($games)>0) : ?>
        <?php foreach($games as $gam) : ?>
    <div class="container">

        <div class="post">
            <div class="header_post">
            <?php 
                $name_modified = str_replace(' ', '', $gam->name);
                $name_remodified = preg_replace('/[^A-Za-z0-9\-]/', '', $name_modified);
                $fileDest1 = "Uploads/" . $gam->userId . "_" . $name_remodified . "." . "jpg";
                $fileDest2 = "Uploads/" . $gam->userId . "_" . $name_remodified . "." . "jpeg";
                $fileDest3 = "Uploads/" . $gam->userId . "_" . $name_remodified . "." . "png"; 
            ?>

            <?php if(file_exists($fileDest1)) : ?>
                <img class="imag" src="<?php echo($fileDest1); ?>" alt="Random placeholder">
            <?php endif ?>

            <?php if(file_exists($fileDest2)) : ?>
                <img class="imag" src="<?php echo($fileDest2); ?>" alt="Random placeholder">
            <?php endif ?>

            <?php if(file_exists($fileDest3)) : ?>
                <img class="imag" src="<?php echo($fileDest3); ?>" alt="Random placeholder">
            <?php endif ?>

            </div>

            <div class="body_post">

                <div class="post_content">

                    <h1> <?php echo($gam->name);  ?> </h1>
                    <p>
                        <?php echo("<b>" . "Developers: " . $gam->compNames . "</b>" . "<br><br>"); ?>
                        <?php echo("<b>" . "Available in: " . $gam->platforms . "</b>" . "<br><br>"); ?>
                        <?php echo("<b>" . "Release date: " .$gam->releaseDate . "</b>" . "<br>"); ?>
                    </p>

                    <div class="container_infos">

                        <div class="postedBy">
                            <span>Entry by:</span>
                            <?php 
                                $que = "SELECT * FROM  `user` WHERE `Id` = '$gam->userId' LIMIT 1;";
                                $res = mysqli_query($db, $que);
                                if(mysqli_num_rows($res)>0)
                                {
                                    while($rw = mysqli_fetch_assoc($res))
                                    {
                                        echo("<b>" . $rw['username'] . "</b>");
                                        $userEmail = $rw['email'];
                                    }
                                }
                            ?>
                        </div>

                        <div class="container_tags">

                            <span>Genres:</span>
                            <?php
                             $qr = "SELECT * FROM usergame_genres WHERE usergameId = '$gam->Id';";
                             $ress = mysqli_query($db, $qr);
                             $ugame_genres = array();
                             if(mysqli_num_rows($ress)>0)
                             {
                                 while($rw = mysqli_fetch_assoc($ress))
                                 {
                                     $ug_genre = new userGameGenres();
                                     $ug_genre->Id = $rw['Id'];
                                     $ug_genre->userGameId = $gam->Id;
                                     $ug_genre->genreId = $rw['genreId'];
                                     array_push($ugame_genres, $ug_genre);
                                 }
                             }
                             $real_genres = array();
                             foreach($ugame_genres as $grr)
                             {
                                 $quer = "SELECT * FROM genres WHERE `Id` = '$grr->genreId' LIMIT 1;";
                                 $r = mysqli_query($db, $quer);
                                 if(mysqli_num_rows($r)>0)
                                 {
                                     while($rw = mysqli_fetch_assoc($r))
                                     {
                                         $gnr = new genre();
                                         $gnr->Id = $rw['Id'];
                                         $gnr->type = $rw['value'];
                                         array_push($real_genres, $gnr);
                                     }
                                 }
                             }
                            ?>
                            <div class="tags">
                                <?php if(count($real_genres)>0) : ?>
                                <ul>
                                    <?php foreach($real_genres as $rg) : ?>
                                    <li> <?php echo("<b>" . $rg->type . " |" . "</b>" . " "); ?> </li>
                                    <?php endforeach ?>
                                </ul>
                                <?php endif ?>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="forma1">
                    <form action="deleteUserGame.php" method="GET">

                    <?php if(file_exists($fileDest1)) : ?>
                        <input type="hidden" name="picture" value="<?php echo($fileDest1); ?>">
                    <?php endif ?>
                    <?php if(file_exists($fileDest2)) : ?>
                        <input type="hidden" name="picture" value="<?php echo($fileDest2); ?>">
                    <?php endif ?>
                    <?php if(file_exists($fileDest3)) : ?>
                        <input type="hidden" name="picture" value="<?php echo($fileDest3); ?>">
                    <?php endif ?>
                        <input required type="hidden" name="emailo1" value="<?php echo($userEmail); ?>">
                        <input required type="hidden" name="hido1" value="<?php echo($gam->Id); ?>">
                        <input type="submit" class="subbce" name="subb1" value="Reject">
                    </form>
                </div>

                <div class="forma2">
                    <form action="approveUserGame.php" method="GET">

                    <?php if(file_exists($fileDest1)) : ?>
                        <input type="hidden" name="picture" value="<?php echo($fileDest1); ?>">
                    <?php endif ?>
                    <?php if(file_exists($fileDest2)) : ?>
                        <input type="hidden" name="picture" value="<?php echo($fileDest2); ?>">
                    <?php endif ?>
                    <?php if(file_exists($fileDest3)) : ?>
                        <input type="hidden" name="picture" value="<?php echo($fileDest3); ?>">
                    <?php endif ?>
                        <input required type="hidden" name="emailo2" value="<?php echo($userEmail); ?>">
                        <input required type="hidden" name="hido2" value="<?php echo($gam->Id); ?>">
                        <input type="submit" class="subbce" name="subb2" value="Approve">
                    </form>
                </div>

            </div>
        
        </div>

    </div>
    <?php endforeach ?>
    <?php endif ?>

</div>

</body>