<?php

    //A simple logIn page

    //is needed to store data in the $_SESSION variable
    session_start();

    //name of the table of the db, where the passwords are stored
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

    //if the input of the form is submitted, the $_POST variable has data
    if($_POST){

        //check if a password is entered ('password' is the name of the password input -> see html part)
        if($_POST['password']){

            //check if password is correct


            $pass = $_POST['password'];

            //checks if the password is in the table
            $query = "SELECT * FROM $table_logIn WHERE password = '".mysqli_real_escape_string($link, $pass)."'";

            $result = mysqli_query($link, $query);

            //if the result 0 rows, the query got no data back
            if(mysqli_num_rows($result) != 0){
                //store the password in the $_SESSION variable to remeber the users has entered the correct password
                //so in other files you can start with
                //session_start();
                //if($_SESSION["password"]){<here all php content for logged In members>}
                $_SESSION["password"] = $_POST['password'];
                //if log in was succesful, redirect to the next page
                header("Location: https://www.basbaer.com/festivals/");
                //after exit no more code from this file will be run
                exit;

            }else{
                //show error message
                echo "<script>alert('Wrong password')</script>"; 
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

        <script type="text/javascript">
            //submitting the post variables by hitting enter so no button is needed

            // Get the input field
            var input = document.getElementById("passwordLogIn");

            // Execute a function when the user releases a key on the keyboard
            input.addEventListener("keyup", function(event) {
            // Number 13 is the "Enter" key on the keyboard
                if (event.keyCode === 13) {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    // Trigger the button element with a click
        
                    function submitform(){
                        document.getElementById("form_password").submit();
                    }
                }
            }); 

        </script>


    </body>





</html>


