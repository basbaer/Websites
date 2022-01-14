<?php

    session_start();

    $table_logIn = "test_password";

    //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");

    //this line is needed to display special characters properly
    $link->query("SET NAMES 'utf8'");

    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        die("Connection Error: Maybe the password contains special characters");
    }

    if($_POST){

        if($_POST['password']){

            //check if password is correct
            $pass = $_POST['password'];

            $query = "SELECT * FROM $table_logIn WHERE password = '".mysqli_real_escape_string($link, $pass)."'";

            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) != 0){
                $_SESSION["password"] = $_POST['password'];
                header("Location: https://www.basbaer.com/festivals/");
                exit;

            }else{
                header("Location: https://www.basbaer.com/");
            }

            

        }

          
      }


?>


<html>
    <head>


    </head>

    <body>
        <h2 class="center_text">Log In</h2>

        <form method="post">
            <input name="password" type="password" id="passwordLogIn">

            <button id="ButtonLogIn">Log in</button>

        </form>


    </body>



</html>


