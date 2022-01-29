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

                        header("Location: https://www.basbaer.com/festivals/");
                        

                    }else{
                        $error.= "password does not match";
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


<html lang="en">

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
            z-index: 1;
        }

        .center_text {
            text-align:center;
        }

        .flip {
            transform: rotate(180deg);

        }

        .blob_motion {
            z-index: 1;
        }

        .blob_content {
            position: absolute;
            display:flex;
            justify-content: center;
            align-items: center;
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
    <main>
        
        <svg id="top_waves" viewBox="0 0 900 130" width="100vw" height="auto" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
            <rect x="0" y="0" width="900" height="300" fill="#FA7268"></rect>
            <path
                d="M0 81L21.5 80.3C43 79.7 86 78.3 128.8 84.5C171.7 90.7 214.3 104.3 257.2 105.7C300 107 343 96 385.8 94.2C428.7 92.3 471.3 99.7 514.2 98.5C557 97.3 600 87.7 642.8 89.3C685.7 91 728.3 104 771.2 106C814 108 857 99 878.5 94.5L900 90L900 0L878.5 0C857 0 814 0 771.2 0C728.3 0 685.7 0 642.8 0C600 0 557 0 514.2 0C471.3 0 428.7 0 385.8 0C343 0 300 0 257.2 0C214.3 0 171.7 0 128.8 0C86 0 43 0 21.5 0L0 0Z"
                fill="#fa7268"></path>
            <path
                d="M0 81L21.5 78.2C43 75.3 86 69.7 128.8 71.5C171.7 73.3 214.3 82.7 257.2 88.3C300 94 343 96 385.8 95.3C428.7 94.7 471.3 91.3 514.2 85.2C557 79 600 70 642.8 69.5C685.7 69 728.3 77 771.2 82.3C814 87.7 857 90.3 878.5 91.7L900 93L900 0L878.5 0C857 0 814 0 771.2 0C728.3 0 685.7 0 642.8 0C600 0 557 0 514.2 0C471.3 0 428.7 0 385.8 0C343 0 300 0 257.2 0C214.3 0 171.7 0 128.8 0C86 0 43 0 21.5 0L0 0Z"
                fill="#ef5f67"></path>
            <path
                d="M0 72L21.5 70.3C43 68.7 86 65.3 128.8 66.2C171.7 67 214.3 72 257.2 75C300 78 343 79 385.8 75.7C428.7 72.3 471.3 64.7 514.2 60.3C557 56 600 55 642.8 57.8C685.7 60.7 728.3 67.3 771.2 67.3C814 67.3 857 60.7 878.5 57.3L900 54L900 0L878.5 0C857 0 814 0 771.2 0C728.3 0 685.7 0 642.8 0C600 0 557 0 514.2 0C471.3 0 428.7 0 385.8 0C343 0 300 0 257.2 0C214.3 0 171.7 0 128.8 0C86 0 43 0 21.5 0L0 0Z"
                fill="#e34c67"></path>
            <path
                d="M0 38L21.5 40.2C43 42.3 86 46.7 128.8 47.5C171.7 48.3 214.3 45.7 257.2 43C300 40.3 343 37.7 385.8 36.7C428.7 35.7 471.3 36.3 514.2 39.2C557 42 600 47 642.8 45.7C685.7 44.3 728.3 36.7 771.2 36.3C814 36 857 43 878.5 46.5L900 50L900 0L878.5 0C857 0 814 0 771.2 0C728.3 0 685.7 0 642.8 0C600 0 557 0 514.2 0C471.3 0 428.7 0 385.8 0C343 0 300 0 257.2 0C214.3 0 171.7 0 128.8 0C86 0 43 0 21.5 0L0 0Z"
                fill="#d53867"></path>
            <path
                d="M0 21L21.5 21.8C43 22.7 86 24.3 128.8 26C171.7 27.7 214.3 29.3 257.2 28C300 26.7 343 22.3 385.8 21.5C428.7 20.7 471.3 23.3 514.2 23.7C557 24 600 22 642.8 23.3C685.7 24.7 728.3 29.3 771.2 29.8C814 30.3 857 26.7 878.5 24.8L900 23L900 0L878.5 0C857 0 814 0 771.2 0C728.3 0 685.7 0 642.8 0C600 0 557 0 514.2 0C471.3 0 428.7 0 385.8 0C343 0 300 0 257.2 0C214.3 0 171.7 0 128.8 0C86 0 43 0 21.5 0L0 0Z"
                fill="#c62368"></path>
        </svg>


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

        <svg id="bottom_waves" viewBox="0 170 900 130" width="100vw" height="auto" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
            <rect x="0" y="0" width="900" height="300" fill="#FA7268"></rect>
            <path
                d="M0 187L21.5 185.2C43 183.3 86 179.7 128.8 183C171.7 186.3 214.3 196.7 257.2 203.8C300 211 343 215 385.8 211C428.7 207 471.3 195 514.2 195.5C557 196 600 209 642.8 210.2C685.7 211.3 728.3 200.7 771.2 198.8C814 197 857 204 878.5 207.5L900 211L900 301L878.5 301C857 301 814 301 771.2 301C728.3 301 685.7 301 642.8 301C600 301 557 301 514.2 301C471.3 301 428.7 301 385.8 301C343 301 300 301 257.2 301C214.3 301 171.7 301 128.8 301C86 301 43 301 21.5 301L0 301Z"
                fill="#fa7268"></path>
            <path
                d="M0 219L21.5 220.7C43 222.3 86 225.7 128.8 225.8C171.7 226 214.3 223 257.2 220.2C300 217.3 343 214.7 385.8 216.5C428.7 218.3 471.3 224.7 514.2 223.5C557 222.3 600 213.7 642.8 214.5C685.7 215.3 728.3 225.7 771.2 229C814 232.3 857 228.7 878.5 226.8L900 225L900 301L878.5 301C857 301 814 301 771.2 301C728.3 301 685.7 301 642.8 301C600 301 557 301 514.2 301C471.3 301 428.7 301 385.8 301C343 301 300 301 257.2 301C214.3 301 171.7 301 128.8 301C86 301 43 301 21.5 301L0 301Z"
                fill="#ef5f67"></path>
            <path
                d="M0 231L21.5 233.7C43 236.3 86 241.7 128.8 240.8C171.7 240 214.3 233 257.2 233.7C300 234.3 343 242.7 385.8 241.7C428.7 240.7 471.3 230.3 514.2 226.7C557 223 600 226 642.8 230.3C685.7 234.7 728.3 240.3 771.2 239.3C814 238.3 857 230.7 878.5 226.8L900 223L900 301L878.5 301C857 301 814 301 771.2 301C728.3 301 685.7 301 642.8 301C600 301 557 301 514.2 301C471.3 301 428.7 301 385.8 301C343 301 300 301 257.2 301C214.3 301 171.7 301 128.8 301C86 301 43 301 21.5 301L0 301Z"
                fill="#e34c67"></path>
            <path
                d="M0 251L21.5 252.8C43 254.7 86 258.3 128.8 257C171.7 255.7 214.3 249.3 257.2 246.3C300 243.3 343 243.7 385.8 248C428.7 252.3 471.3 260.7 514.2 262C557 263.3 600 257.7 642.8 256.5C685.7 255.3 728.3 258.7 771.2 259.7C814 260.7 857 259.3 878.5 258.7L900 258L900 301L878.5 301C857 301 814 301 771.2 301C728.3 301 685.7 301 642.8 301C600 301 557 301 514.2 301C471.3 301 428.7 301 385.8 301C343 301 300 301 257.2 301C214.3 301 171.7 301 128.8 301C86 301 43 301 21.5 301L0 301Z"
                fill="#d53867"></path>
            <path
                d="M0 277L21.5 277.5C43 278 86 279 128.8 278.3C171.7 277.7 214.3 275.3 257.2 272.5C300 269.7 343 266.3 385.8 266.5C428.7 266.7 471.3 270.3 514.2 271.7C557 273 600 272 642.8 273.7C685.7 275.3 728.3 279.7 771.2 279.3C814 279 857 274 878.5 271.5L900 269L900 301L878.5 301C857 301 814 301 771.2 301C728.3 301 685.7 301 642.8 301C600 301 557 301 514.2 301C471.3 301 428.7 301 385.8 301C343 301 300 301 257.2 301C214.3 301 171.7 301 128.8 301C86 301 43 301 21.5 301L0 301Z"
                fill="#c62368"></path>
        </svg>

    </main>

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



</html>

