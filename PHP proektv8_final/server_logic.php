<?php
if(isset($_POST['Register'])) 
{
    $fname = "";
    $lname = "";
    $uname = "";
    $pass1 = "";
    $pass2="";
    $email="";
    $bdate="";

    $errors = array();
    $db = mysqli_connect('localhost', 'root', '', 'php_repository') or die('Could not connect to the database!');


    $fname = mb_convert_encoding($_POST['Fname'], 'UTF-8', 'UTF-8');
    $fname = htmlentities($fname, ENT_QUOTES, 'UTF-8');
    $lname = mb_convert_encoding($_POST['Lname'], 'UTF-8', 'UTF-8');
    $lname = htmlentities($lname, ENT_QUOTES, 'UTF-8');
    $uname = mb_convert_encoding($_POST['Uname'], 'UTF-8', 'UTF-8');
    $uname = htmlentities($uname, ENT_QUOTES, 'UTF-8');
    $pass1 = mb_convert_encoding($_POST['Pass'], 'UTF-8', 'UTF-8');
    $pass1 = htmlentities($pass1, ENT_QUOTES, 'UTF-8');
    $pass2 = mb_convert_encoding($_POST['CPass'], 'UTF-8', 'UTF-8');
    $pass2 = htmlentities($pass2, ENT_QUOTES, 'UTF-8');
    $email = mb_convert_encoding($_POST['Ename'], 'UTF-8', 'UTF-8');
    $email = htmlentities($email, ENT_QUOTES, 'UTF-8');

    $fname_escaped = mysqli_real_escape_string($db, $fname);
    $lname_escaped = mysqli_real_escape_string($db, $lname);
    $uname_escaped = mysqli_real_escape_string($db, $uname);
    $email_escaped = mysqli_real_escape_string($db, $email);
    $pass1_escaped = mysqli_real_escape_string($db, $pass1);
    $bdate = $_POST['Bdate'];
    $gender = $_POST['gender'];

    if(empty($fname)) { array_push($errors, 'First name is empty.');}
    if(empty($lname)) { array_push($errors, 'Last name is empty.');}
    
    if(empty($uname)) { array_push($errors, 'Username is empty.');}
    if(empty($email)) { array_push($errors, 'Email is empty.');}
    if(empty($pass1)) { array_push($errors, 'Password is empty.');}
    if(empty($pass2)) { array_push($errors, 'Please confirm password.');}
    if($pass1 != $pass2) { array_push($errors, 'Passwords do not match.');}
    if(!isset($bdate)) {array_push($errors, "Please enter birth date.");}
    if(!isset($gender)) {array_push($errors, "Please select your gender.");}
    if(!(filter_var($email, FILTER_VALIDATE_EMAIL))) { array_push($errors, 'Invalid email entered.'); }

    if(strlen($uname)<4) {  array_push($errors, "Username must be atleast 4 characters."); }
    $uppercase = preg_match('/[A-Z]/', $pass1);
    $lowercase = preg_match('/[a-z]/', $pass1);
    $number = preg_match('/[0-9]/', $pass1);
    if(strlen($pass1) < 8) 
    { array_push($errors, "Password must contain atleast 8 characters."); }
    if(!$uppercase) { array_push($errors, "Password must contain atleast 1 uppercase character.");}
    if(!$lowercase) { array_push($errors, "Password must contain atleast 1 lowercase character.");}
    if(!$number) { array_push($errors, "Password must contain atleast 1 number.");}

    $check_existing_user = "SELECT * FROM user WHERE username = '$uname_escaped' OR email = '$email_escaped' LIMIT 1";
    $result_query = mysqli_query($db, $check_existing_user);

    if(mysqli_num_rows($result_query)>0)
    {
        while($row = mysqli_fetch_assoc($result_query)) 
        {
            if($row['username'] == $uname_escaped) {array_push($errors, 'Username is already taken.');}
            if($row['email'] == $email_escaped) {array_push($errors, 'Email is already taken.');}
        }
    }

    if(count($errors)==0)
    {
        $hashed_pass = md5($pass1_escaped);
        $insert_query = "INSERT INTO user (firstName, lastName, email, username, `password`, birthDate) VALUES ('$fname_escaped', '$lname_escaped', '$email_escaped', '$uname_escaped', '$hashed_pass', '$bdate');";
        mysqli_query($db, $insert_query);
        header("location: Login.php");
    }
}
?>