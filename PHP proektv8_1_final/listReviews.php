<?php include("rateHelpful.php"); ?>
<?php include("rateNotHelful.php"); ?>
<?php include("deleteReview.php"); ?>
<?php
    if(isset($_GET['subtton']))
    {
        session_start();
        if(isset($_SESSION['admin'])) {$admince = true;}
        else {$admince = false;
            $logged_id =  $_SESSION['id'];}
        if(!(isset($_SESSION['succsess_login'])))
        { header("location: Login.php"); }
        $gameId = $_GET['hidId'];
        $gameName = $_GET['hidName'];
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
    <?php if(!$admince) : ?>
    <form method="GET" action="writeReview.php" class="formulce">
        <input type="hidden" value="<?php echo($logged_id); ?>" name="writeId">
        <input type="hidden" value="<?php echo($gameName); ?>" name="writegameName">
        <input type="hidden" value="<?php echo($gameId); ?>" name="writegameId">
        <input class="kopce" type="submit" name="writeButton" value="Write a review">
    </form>
    <?php endif ?>

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
                    <?php if(!$admince) : ?>   
                    <?php
                        $slc = "SELECT * FROM reviewrating WHERE reviewId = '$rvw->Id' AND userId = '$logged_id';";
                        $revrt = mysqli_query($db, $slc);
                        $rating = new reviewRating();
                        if(mysqli_num_rows($revrt)==0)
                        {
                            $insert = "INSERT INTO reviewrating (helpful, userId, reviewId) VALUES (0, '$logged_id', '$rvw->Id');";
                            mysqli_query($db, $insert);
                            $slc1 = "SELECT * FROM reviewrating WHERE reviewId = '$rvw->Id' AND userId = '$logged_id';";
                            $ne = mysqli_query($db, $slc1);
                            if(mysqli_num_rows($ne)>0)
                            {
                                while($row = mysqli_fetch_assoc($ne))
                                {
                                    $rating->helpful = $row['helpful'];
                                    $rating->userId = $row['userId'];
                                    $rating->Id = $row['Id'];
                                    $rating->reviewId = $row['reviewId'];
                                }
                            }
                        }
                        else
                        {
                            while($row = mysqli_fetch_assoc($revrt))
                            {
                                $rating->helpful = $row['helpful'];
                                $rating->userId = $row['userId'];
                                $rating->Id = $row['Id'];
                                $rating->reviewId = $row['reviewId'];
                            }
                        }
                    ?>
                    <?php endif ?>

                    <?php if($admince) : ?>
                        <form class="maloformce" method="POST" action="listReviews.php?hidId=<?php echo($gameId); ?>&hidName=<?php echo($gameName); ?>&subtton=See+Reviews">
                        <input required type="hidden" value="<?php echo($rvw->Id); ?>" name="deletedId">
                        <input type="submit" class="subce2" name="deleteReview" value="Delete review">
                        </form>
                    <?php endif ?>

                    <?php if(!$admince) : ?>
                    <?php if($logged_id != $rvw->userId) : ?>
                    <?php if($rating->helpful == 0) : ?>
                    <form class="maloformce" method="POST" action="listReviews.php?hidId=<?php echo($gameId); ?>&hidName=<?php echo($gameName); ?>&subtton=See+Reviews">
                        <input required type="hidden" value="<?php echo($rating->Id); ?>" name="ratingId">
                        <input type="submit" class="subce" name="helpsub" value="Helpful">
                    </form>
                    <?php endif ?>
                    <?php endif ?>
                    <?php endif ?>

                    <?php if(!$admince) : ?>
                    <?php if($logged_id != $rvw->userId) : ?>
                    <?php if($rating->helpful == 1) : ?>
                    <form class="maloformce" method="POST" action="listReviews.php?hidId=<?php echo($gameId); ?>&hidName=<?php echo($gameName); ?>&subtton=See+Reviews">
                        <input required type="hidden" value="<?php echo($rating->Id); ?>" name="ratingId">
                        <input type="submit" class="subce2" name="nothelpsub" value="Not helpful">
                    </form>
                    <?php endif ?>
                    <?php endif ?>
                    <?php endif ?>

                    </div>
                </article>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <?php if(count($reviews)==0) : ?>
        <h2 class = "subtitl">No reviews found</h2>
    <?php endif ?>
</body>