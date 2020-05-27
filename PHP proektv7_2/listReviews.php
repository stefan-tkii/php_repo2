<?php
    if(isset($_GET['subtton']))
    {
        session_start();
        $gameId = $_GET['hidId'];
        $gameName = $_GET['hidName'];
        $logged_id =  $_SESSION['id'];
        $user = $_SESSION['username'];
        $pageName = "Game reviews";
        include("navbar.php");
        include("./Models/review.php");
        include("./Models/reviewRating.php");
        include("./Models/User.php");
        $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');
        $query = "SELECT * FROM review WHERE gameId = '$gameId';";
        $results = mysqli_query($db, $query);
        $reviews = array();
        if(mysqli_num_rows($results)>0)
        {
            while($row = mysqli_fetch_assoc($results))
            {
                $item = new review();
                $item->Id = $row['Id'];
                $item->content = $row['content'];
                $item->userId = $row['userId'];
                $item->gameId = $row['gameId'];
                array_push($reviews, $item);
            }
        }
    }
?>

<!DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="reviewList.css"/>
    </head>

<body>
    <h1 class="titl">Reviews for <?php echo($gameName); ?></h1>

    <form method="GET" action="writeReview.php" class="formulce">
        <input type="hidden" value="<?php echo($logged_id); ?>" name="writeId">
        <input type="hidden" value="<?php echo($gameName); ?>" name="writegameName">
        <input type="hidden" value="<?php echo($gameId); ?>" name="writegameId">
        <input class="kopce" type="submit" name="writeButton" value="Write a review">
    </form>

    <div class="reviews_container">
        <?php if(count($reviews)>0) : ?>
            <?php foreach($reviews as $rvw) : ?>
                <?php
                    $get_user = "SELECT * FROM user WHERE `Id` = '$rvw->userId';";
                    $us_res = mysqli_query($db, $get_user);
                    $wrote = new user();
                    if(mysqli_num_rows($us_res)>0)
                    {
                        while($row = mysqli_fetch_assoc($us_res))
                        {
                            $wrote->Id = $row['Id'];
                            $wrote->firstName = $row['firstName'];
                            $wrote->lastName = $row['lastName'];
                            $wrote->username = $row['username'];
                            $wrote->email = $row['email'];
                        }
                    }
                    $get_ratings = "SELECT * FROM reviewrating WHERE reviewId = '$rvw->Id' AND helpful = 1;";
                    $ress = mysqli_query($db, $get_ratings);
                    $helpful = mysqli_num_rows($ress);
                ?>
                <article class="review">
                    <div class="subl">
                    <h3 class="sm">Review from : <?php echo($wrote->username); ?></h3> 
                    <p class="sp"> <?php echo($helpful . " "); ?> users found this review helpful </p>
                    </div>
                    <p class=cont> <?php echo($rvw->content); ?> </p>
                    <div class="subtl">
                    <form class="maloformce" method="POST" action="rateHelpful.php">
                        <input required type="hidden" value="<?php echo($rvw->Id); ?>" name="reviewId">
                        <input required type="hidden" value="<?php echo($logged_id); ?>" name="userId">
                        <input type="submit" class="subce" value="Helpful">
                    </form>
                    </div>
                </article>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <?php if(count($reviews)==0) : ?>
        <h2 class = "subtitl">No reviews found</h2>
    <?php endif ?>
</body>