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

    echo $error;


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
            margin: 0;
            font-family: 'M PLUS 1 Code', sans-serif;
            color: white;
            background: #FA7268;
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

        section {
            position: relative;
            z-index: 1;
        }

        .center_text {
            text-align:center;
        }

        .flip {
            transform: rotate(180deg);

        }

        .blob_motion {
            position: absolute;
            z-index: 1;
        }

        .blob_content {
            z-index: 2;
            display:flex;
            justify-content: center;
            margin-top: 25vh;
            margin-left: 45vw;
            position:absolute;
            align-items: center;

            /*
            
            width: 50vw;
            height: 20vh;
            top: 40vh;
            left: 25vw;
            z-index: 2; /* makes it appear over blob-motion because of the higher z-index */
        }

        #top_waves {
            position: fixed;
            top: 0;
            z-index: 0;
        }

        #bottom_waves {
            position: fixed;
            bottom: 0;
            z-index: 0;
        }
    </style>


</head>

<body>


    <section>
            <svg class="blob_motion" id="visual" viewBox="0 0 900 300" width="100vw" height="auto"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
                <g transform="translate(448.5426058915106 143.74371554266904)">
                    <path id="blob_0"
                        d="M63.7 -54.8C88.7 -38.7 119.3 -19.3 118.5 -0.8C117.7 17.7 85.4 35.4 60.4 56.7C35.4 78 17.7 103 -3.8 106.8C-25.2 110.6 -50.4 93.1 -71.9 71.8C-93.4 50.4 -111.2 25.2 -114.9 -3.7C-118.5 -32.5 -108.1 -65.1 -86.6 -81.2C-65.1 -97.4 -32.5 -97.2 -6.6 -90.6C19.3 -84 38.7 -71 63.7 -54.8"
                        fill="#C62368"></path>
                </g>
                <g transform="translate(458.38458696758266 141.53148459473746)" style="visibility: hidden">
                    <path id="blob_1"
                        d="M80.6 -78.8C99.9 -61.3 108 -30.6 109.3 1.3C110.6 33.2 105.1 66.5 85.8 86.8C66.5 107.1 33.2 114.6 0.7 113.9C-31.8 113.2 -63.6 104.3 -88.6 84C-113.6 63.6 -131.8 31.8 -124.7 7.1C-117.7 -17.7 -85.4 -35.4 -60.4 -52.9C-35.4 -70.4 -17.7 -87.7 6.5 -94.2C30.6 -100.6 61.3 -96.3 80.6 -78.8"
                        fill="#C62368"></path>
                </g>
            </svg>

            <div class="blob_content">
                <div>
                    <h2 class="center_text">Log In</h2>

                    <form method="post" id="form_password">
                        <input name="password" type="password" id="passwordLogIn">
                    </form>

                </div>
            </div>


            <script>
                const tween = KUTE.fromTo(
                    '#blob_0',
                    { path: '#blob_0' },
                    { path: '#blob_1' },
                    { repeat: 999, duration: 3000, yoyo: true }
                ).start();
            </script>
        </section>

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