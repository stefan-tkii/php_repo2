<?php
    session_start();
    $user = $_SESSION['username'];
    include('./Models/genre.php');
    include('send.php');
    $pageName = "Game entry";
    $genres = array();
    include("navbar.php");
    if(!(isset($_SESSION['succsess_login'])))
    { header("location: Login.php"); }
    $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
    $query = "SELECT * FROM `genres`";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $gnr = new genre();
            $gnr->Id = $row['Id'];
            $gnr->type = $row['value'];
            array_push($genres, $gnr);
        }
    }
    include('entry_backend.php');
?>

<!DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="entry_style.css"/>
    </head>

<body>
    
<div class="form-style-6">
<h1>Fill the game's details</h1>
<form method="POST" action="gameEntry.php" enctype="multipart/form-data">
<?php if(isset($_POST['subce'])) : ?>
    <?php if(count($errs)>0) : ?>
        <?php foreach($errs as $er) : ?>
            <?php echo("<b>" . "Error: " . $er . "</b>" . "<br>"); ?>
        <?php endforeach ?>
        <?php echo("<br> <br>"); ?>
    <?php endif ?>
<?php endif ?>

<label id="lab" for="game_name">Enter the name: </label>
<input required type="text" id="game_name" name="game_name" placeholder="Game's name" />
<label id="lab" for="game_comp">Enter the names of companies who made it separated with ',' : </label>
<input required type="text" id="game_comp" name="game_comp" placeholder="Company's names" />
<label id="lab" for="game_platforms">Enter the platforms in which the game is available separated with ',' : </label>
<input required type="text" id="game_platforms" name="game_platforms" placeholder="Platforms" />
<label id="lab" for="game_date">Enter the release date of the game: </label>
<input required type="date" id="game_date" name="game_date" min="1960-01-01" max="2020-03-01"/>
<?php if(count($genres)>0) : ?>
    <label id="lab" for="divce">Select multiple genres from the list below with ctrl + click: </label>
    <div id="divce">
    <select required size="6" name="selected[]" multiple>
        <?php foreach($genres as $opt) : ?>
            <option value="<?php echo($opt->Id); ?>"> <?php echo($opt->type); ?> </option>
        <?php endforeach ?>
    </select>
    <div>
<?php endif ?>
<label id="lab" for="game_image">Upload an image for the game:</label>
<input required id="game_image" type="file" name="game_image">
<br>
<input type="submit" name="subce" value="Apply" />
</form>
</div>

</body>


