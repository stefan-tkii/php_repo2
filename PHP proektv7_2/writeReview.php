<?php
    if(isset($_GET['writeButton']))
    {
        session_start();
        $user = $_SESSION['username'];
        $pageName = "Write review";
        $reviewFor = $_GET['writegameId'];
        $reviewForName = $_GET['writegameName'];
        $reviewBy = $_GET['writeId'];
        include("navbar.php");
    }
?>

<!DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="writeReview.css"/>
    </head>

<body>
    
<div class="form-style-6">
<h1>Fill the review's contents</h1>
<form method="POST" action="publishReview.php">
<label id="lab" for="review_content">Enter the details: </label>
<textarea required id="review_contents" rows="16" cols="80" name="review_contents">Write what's on your mind...</textarea>
<br>
<input type="submit" name="publish" value="Publish review" />
</form>
</div>

</body>