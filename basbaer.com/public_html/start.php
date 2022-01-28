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

                        //header("Location: https://www.basbaer.com/festivals/");


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

    echo $error;


?>

<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basti</title>

</head>

<body>
    <div class="container-md bg-danger">100% wide until extra large breakpoint</div>

    <form method="post" id="form_password">
        <input name="password" type="password" id="passwordLogIn">
    </form>

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