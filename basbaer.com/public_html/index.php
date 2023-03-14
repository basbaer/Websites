

<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bas Baer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/kute.js@2.1.2/dist/kute.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" >



    <style>
        body {

            font-family: 'M PLUS 1 Code', sans-serif;
            background-image: url("pictures/bg_2.jpg");
            background-size: cover;
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

        .hidden_at_start{
            visibility: hidden;
        }

        #wrap{
            margin-top: 20vh;
            text-align: center;
        }

        #pw_incorrect{
            color: white;
        }




    </style>


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="festivals/">Festivals</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="food/">Calendar</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
            

           
    <div id="wrap">
        <h2 class="center_text">Log In</h2>

        <form method="post" id="form_password">
            <input class="form-control mx-auto w-25" type="text" placeholder="Password" id="passwordLogIn" name="password">
        </form>

        <div class="container">
            <p class="hidden_at_start" id="pw_incorrect">Password is incorrect</p>
        </div>

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

<?php

    session_start();

    $table_logIn = "FestivalLogIn";
    $col_id = "id";
    $col_pass = "password";
    $col_admin = "admin";

    //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    //$link = mysqli_connect("sdb-f.hosting.stackcp.net", "logInDb-3138340968", "ud0uz58bam", "logInDb-3138340968");
    $link = mysqli_connect("mysql.stackcp.com", "logInDb-3138340968", "ud0uz58bam", "logInDb-3138340968", "58438");

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
                
                //run over all passwords in the logIn table
                foreach ($rows as $row){

                    $pass_index = 1;
                    $admin_index = 2;

                    //checks if given password is in table
                    if (password_verify($pass, $row[$pass_index])) {

                        //1 if the user has admin rights, 0 if not
                        $_SESSION['admin'] = $row[$admin_index];

                        //password is encryption key for database
                        $_SESSION['password'] = $pass;

                        $error .= "row: $row[$admin_index]<br>Session: ".$_SESSION['admin']."<br>";

                        //header("Location: festivals/");

                        header("Location: food/");

                        session_write_close();


                    }else{

                        //show password is not correct
                        ?>
                        <script type="text/javascript">
                            // Get the input field
                            var pw_inc = document.getElementById("pw_incorrect");

                            pw_inc.style.visibility= "visible";

                        </script>

                        <?php

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


    //echo $error;


?>