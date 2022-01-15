<?php

    $error = "";

    session_start();

    //log the user out
    if(array_key_exists('logout', $_GET)){
        session_unset();
        setcookie("id", "0", 1);
        $_COOKIE["id"] = "";

        $error .= "User is logged out";
        
    }

    //if user is logged in, redirect to loggedInPage
    if(array_key_exists("id", $_COOKIE) || array_key_exists("id", $_SESSION)){
        
        header("Location: loggedInPage.php");
    }

    //variables
    $user_table = "Users";
    $col_id = "id";
    $col_mail = "email";
    $col_pass = "password";

    //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    $link = mysqli_connect("sdb-f.hosting.stackcp.net", "logInDb-3138340968", "ud0uz58bam", "logInDb-3138340968");

    //this line is needed to display special characters properly
    $link->query("SET NAMES 'utf8'");

    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        die("Connection Error: Maybe the password contains special characters");
    }





    //is True when something is submitted
    if($_POST){
        //Log in
        if($_POST['submitButton'] == 'Log In'){

            //check if every necessary field is provided
            if(!$_POST['logInMail']){
                //error message
                $error .= "Please enter mail<br>";
            }

            if(!$_POST['logInPassword']){
                //error message
                $error .= "Please enter Password<br>";
            }

            //check if user is in db
            $query = "SELECT * FROM $user_table WHERE $col_mail = '".mysqli_real_escape_string($link, $_POST['logInMail'])."'";

            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) == 0){
                //no user with this email
                $error .= "No user with this mail<br>";
            }

            $user_array = mysqli_fetch_row($result);

            $user_id_index = 0;
            $user_pass_index = 2;

            //check if password is correct
            if (password_verify($_POST['logInPassword'], $user_array[$user_pass_index])) {
                //password was correct
                $error .=  'Password is valid! You are logged in<br>';

                $_SESSION['id'] = $user_array[$user_id_index];

                //set cookie
                if($_POST['stayLoggedIn0']){

                    $error .=  "Cookie set<br>";

                    setcookie('id', $user_array[$user_id_index], time() + 60 * 60 * 24 * 250);

                }

                header("Location: loggedInPage.php");

            } else {
                //incorrect password
                $error .=  'Invalid password<br>';
            }


        }


        //Sign Up
        if($_POST['submitButton'] == 'Sign Up'){
            
            //check if every necessary field is provided
            if(!$_POST['signUpMail']){
                //error message
                $error .= "please enter mail<br>";
            }

            if(!$_POST['signUpPassword']){
                //error message
                $error .= "please enter Password<br>";
            }

            //check if email already exists
            $query = "SELECT * FROM $user_table WHERE $col_mail = '".mysqli_real_escape_string($link, $_POST['signUpMail'])."'";

            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) != 0){
                //email already exists
                $error .= "mail exists already<br>";
            }


            //add user to table
            $pass_hash = password_hash($_POST['signUpPassword'], PASSWORD_DEFAULT);

            $query = "INSERT INTO $user_table ($col_id, $col_mail, $col_pass) VALUES (NULL, '"
            .mysqli_real_escape_string($link, $_POST['signUpMail'])."', '".$pass_hash."')";

            if(mysqli_query($link, $query)){
                //user succesfull added
                $error .=  "user added succesfull<br>";

                $id = mysqli_insert_id($link);

                $_SESSION['id'] = $id;

                //set cookie
                if($_POST['stayLoggedIn1']){

                    $error .=  "Cookie set<br>";

                    setcookie('id', $id, time() + 60 * 60 * 24 * 250);

                }

                header("Location: loggedInPage.php");

                exit;


            }else{
                //user not added
                $error .= "Oops something went wrong - user not added<br>";
            }




        }

    }

    print_r($_COOKIE);

    echo "<br>";

    print_r($_SESSION);

    echo "<br>";

    echo $error;



?>

<html>
	<head>
		
		<meta charset="utf-8" />

		<title>Log In/Sign Up</title>
		
	<head>

	<body>
        
        <div id="logInDiv">
            <form method="post">
                <input type="email" name="logInMail" id="logInMail" placeholder="Type Email">
                <input type="password" name="logInPassword" id="logInPassword" placeholder="Type Password">
                <input type="checkbox" name="stayLoggedIn0" id="stayLoggedIn0">
                <input type="submit" name="submitButton" id="submitLogIn" value="Log In">
            </form>
        </div>

        <br>

        <div id="signUpDiv">
            <form method="post">
                <input type="email" name="signUpMail" id="signUpMail" placeholder="Type Email">
                <input type="password" name="signUpPassword" id="signUpPassword" placeholder="Type Password">
                <input type="checkbox" name="stayLoggedIn1" id="stayLoggedIn1"> 
                <input type="submit" name="submitButton" id="submitSignUp" value="Sign Up"> 
            </form>
        </div>

        
        <script type="text/javascript">
            //submitting the post variables by hitting enter so no button is needed

            // Get the input field
            var input = document.getElementById("logInPassword");

            // Execute a function when the user releases a key on the keyboard
            input.addEventListener("keyup", function(event) {
            // Number 13 is the "Enter" key on the keyboard
                if (event.keyCode === 13) {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    // Trigger the button element with a click
                    document.getElementById('submitLogIn').submit();
                    
                }
            }); 

            var input = document.getElementById("signUpPassword");

            // Execute a function when the user releases a key on the keyboard
            input.addEventListener("keyup", function(event) {
            // Number 13 is the "Enter" key on the keyboard
                if (event.keyCode === 13) {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    // Trigger the button element with a click
                    document.getElementById('submitSignUp').submit();
                    
                }
            }); 

        </script>
        
		
	</body>
</html>
