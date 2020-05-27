<?php include('server_logic.php') ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register page</title>
        <link rel="stylesheet" type="text/css" href="asset_reg.css"/>
    </head>
    <body> 
            <h1>Registration form</h1>
            <div class="register">
                <form method="POST" action="Register.php" class="regform">
                <?php if(isset($_POST['Register'])) : ?>
                    <?php include('errors.php') ?>
                <?php endif ?>
                    <br>

                    <label>First name: </label> <br>
					<input type="text" maxlength="25" name="Fname" class="Fnamec" placeholder="Enter first name" required> <br> <br>
					
                    <label>Last name: </label> <br>
					<input type="text" maxlength="35" name="Lname" class="Fnamec" placeholder="Enter last name" required> <br> <br>

                    <label>Username: </label> <br>
					<input type="text" maxlength="25" name="Uname" class="Fnamec" placeholder="Enter username" required> <br> <br>
					
                    <label>Email: </label> <br>
					<input type="text" maxlength="35" name="Ename" class="Fnamec" placeholder="Enter email address" required> <br> <br>
					
                    <label>Password: </label> <br>
					<input type="password" maxlength="50" name="Pass" class="Fnamec" placeholder="Enter password" required> <br> <br>
					
                    <label>Confirm password: </label> <br>
					<input type="password" maxlength="50" name="CPass" class="Fnamec" placeholder="Confirm password" required> <br> <br>

					<label>Enter your birth date: </label> <br>
						<input type="date" min="1900-01-01" max="2020-01-01" name="Bdate" required> <br> <br>

                    <label>Select your gender: </label> <br>
                    <input type="radio" name="gender" value="male" required> Male
					<input type="radio" name="gender" value="female"> Female <br> <br>
					
					<input type="submit" name="Register" class="sub" value="Register">
					
                </form>
            </div>
    </body>
</html>