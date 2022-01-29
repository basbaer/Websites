<?php

    session_start();

    $table_logIn = "FestivalLogIn";
    $col_id = "id";
    $col_pass = "password";
    $col_admin = "admin";

    //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    $link = mysqli_connect("sdb-f.hosting.stackcp.net", "logInDb-3138340968", "ud0uz58bam", "logInDb-3138340968");

    //this line is needed to display special characters properly
    $link->query("SET NAMES 'utf8'");

    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        die("Connection Error: Maybe the password contains special characters");
    }


    $error = "";

    if($_POST){

        if($_POST['password']){

            //check if password is correct
            $pass = $_POST['password'];

            $query = "SELECT * FROM $table_logIn";

            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) > 0){

                $rows = mysqli_fetch_all($result);

                foreach ($rows as $row){

                    $pass_index = 1;
                    $admin_index = 2;

                    if (password_verify($pass, $row[$pass_index])) {

                        $_SESSION['admin'] = $row[$admin_index];

                        $error .= "row: $row[$admin_index]<br>Session: ".$_SESSION['admin']."<br>";

                        header("Location: festivals/");

                        session_write_close();


                    }else{
                        $error.= "password does not match<br>";
                    }
                }

                
            }

        }else{
            $error .= "No password in POST";
        }

          
    }else{
        $error .= "No POST variable<br>";
    }

    $error .= "Session: ".$_SESSION['admin']."<br>";

    //echo $error;


?>

<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Good Stuff</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/kute.js@2.1.2/dist/kute.min.js"></script>

    <style>
        body {

            font-family: 'M PLUS 1 Code', sans-serif;
            background-image: url("pictures/bg_2.JPG");
            margin: 0;
            overflow-x: hidden; /* no scrolling is possible */
            overflow-y: hidden;
            
        }

        main {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
        }



        h1 {
            font-size: 3vmin; /* font size relative to the viewport */
            
        }

        .center_text{
            text-align: center;
            color: white;
        }

        #wrap{
            margin-top: 20vh;
            text-align: center;
        }
    </style>


</head>

<body>

           
    <div id="wrap">
        <h2 class="center_text">Log In</h2>

        <form method="post" id="form_password">
            <input name="password" type="password" id="passwordLogIn">
        </form>

    </div>



    <script type="text/javascript">
        // Get the input field
        var input = document.getElementById("passwordLogIn");

        // Execute a function when the user releases a key on the keyboard
        input.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                //document.getElementById("ButtonLogIn").click();
                function submitform(){
                    document.getElementById("form_password").submit();
                }
            }
        }); 

    </script>

</body>



</html>