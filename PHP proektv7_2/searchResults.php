<?php
    if(isset($_GET['searchButton']))
    {
        session_start();
        $user = $_SESSION['username'];
        $pageName = "Search results";
        include("./Models/Game.php");
        include("./Models/genre.php");
        include("./Models/gameGenres.php");
        include("navbar.php");
        $result_array = array();
        $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
        $name_query = mb_convert_encoding($_GET['search'], 'UTF-8', 'UTF-8');
        $name_query = htmlentities($name_query, ENT_QUOTES, 'UTF-8');
        $name_query_escaped = mysqli_real_escape_string($db, $name_query);
        $query = "SELECT * FROM `game` WHERE `name` LIKE '%$name_query_escaped%';";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)>0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $game = new game();
                $game->Id = $row['Id'];
                $game->name = $row['name'];
                $game->compNames = $row['compNames'];
                $game->platforms = $row['platforms'];
                $game->releaseDate = $row['releaseDate'];
                array_push($result_array, $game);
            } 
        }
    }
?>

<!DOCTYPE html>

<head>
    <link rel = "stylesheet" type = "text/css" href = "gameCardStyle.css"/>
</head>

<body>

<?php if(count($result_array)>0) : ?>
    <div class="container">
    <?php foreach($result_array as $res) : ?>
        <div class="card">
            <div class="card-header">
                <h2 class="h2_class"><b><?php echo($res->name); ?></b></h2>
            </div>
            <div class="card-main">
                <?php
                    $name_modified = str_replace(' ', '', $res->name);
                    $name_remodified = preg_replace('/[^A-Za-z0-9\-]/', '', $name_modified);
                    $fileDest1 = "Assets/admin_" . $name_remodified . ".jpg"; 
                    $fileDest2 = "Assets/admin_" . $name_remodified . ".jpeg"; 
                    $fileDest3 = "Assets/admin_" . $name_remodified . ".png";  
                ?>

                <?php if(file_exists($fileDest1)) : ?>
                    <img src="<?php echo($fileDest1); ?>" alt="Image placeholder" style="width:100%" height="250px" width="450px" class="imag">
                <?php endif ?>

                <?php if(file_exists($fileDest2)) : ?>
                    <img src="<?php echo($fileDest2); ?>" alt="Image placeholder" style="width:100%" height="250px" width="450px" class="imag">
                <?php endif ?>

                <?php if(file_exists($fileDest3)) : ?>
                    <img src="<?php echo($fileDest3); ?>" alt="Image placeholder" style="width:100%" height="250px" width="450px" class="imag">
                <?php endif ?>

                <?php
                    $new_query = "SELECT * FROM game_genres WHERE gameId = '$res->Id';";
                    $game_genres_list = array();
                    $list_result = mysqli_query($db, $new_query);
                    if(mysqli_num_rows($list_result)>0)
                    {
                        while($row = mysqli_fetch_assoc($list_result))
                        {
                            $item = new gameGenres();
                            $item->Id = $row['Id'];
                            $item->gameId = $row['gameId'];
                            $item->genreId = $row['genreId'];
                            array_push($game_genres_list, $item);
                        }
                    }
                    $genres = array();
                    foreach($game_genres_list as $gnr)
                    {
                        $srch = "SELECT * FROM genres WHERE `Id` = '$gnr->genreId';";
                        $ress = mysqli_query($db, $srch);
                        if(mysqli_num_rows($ress)>0)
                        {
                            while($row = mysqli_fetch_assoc($ress))
                            {
                                $gen = new genre();
                                $gen->Id = $row['Id'];
                                $gen->type = $row['value'];
                                array_push($genres, $gen);
                            }
                        }
                    }
                ?>
                <h4>Available on: <?php echo $res->platforms ?></h4>
                <h4>Released on: <?php echo $res->releaseDate ?></h4>
                <h4>Genres: <?php echo("| "); ?>
                    <?php foreach($genres as $gn) : ?>
                        <?php echo($gn->type . " | "); ?>
                    <?php endforeach ?>    
                </h4>
            </div>

            <div class="card-footer">
                <h4><i>Delevopers: <?php echo($res->compNames); ?></i></h4>
            </div>

            <form method="GET" action="listReviews.php" class="card-form">
                <input required type="hidden" name="hidId" value="<?php echo($res->Id); ?>">
                <input required type="hidden" name="hidName" value="<?php echo($res->name); ?>">
                <input class="form-but" type="submit" value="See Reviews" name="subtton">
            </form>
        </div>

    <?php endforeach ?>

    </div>

<?php endif ?>

<?php if(mysqli_num_rows($result) == 0): ?>
    <div>
        <h1 style="text-align: center"><b>No search results found.<b><h1>
    </div>
<?php endif ?>

</body>