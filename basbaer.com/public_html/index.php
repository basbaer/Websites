<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bas Baer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/kute.js@2.1.2/dist/kute.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 

    <link rel="stylesheet" href="style.css">


</head>

<body>
    <div class="background"></div>
    
        <div class="container-fluid d-flex justify-content-end">
            <div class="row">
                <form class="d-inline-flex py-2 mb-0" action="util/sendPassword.php" method="post" id="form_password">
                        <input class="form-control me-2" type="password" placeholder="Password" aria-label="Password" id="passwordLogIn" name="password">
                        <button class="btn btn-outline-success text-nowrap" type="submit">Log In</button>
                    </form>
                </div>
        </div>


    <div id="blogTitleContainer" class="d-flex justify-content-center my-3">
        <h1 id="blogTitle" class="text-center text-light bg-dark bg-opacity-75 px-3 py-2 border border-white">Basti's Blog</h1>
    </div> 

    <?php
        // connect to db
        include "util/ConnectDB.php";
        require_once "config.php";

        //db variables
        //Blog table - variables from config.php
        $table_name = TABLE_BLOG;
        $col_postId = BLOGPOST_ID;
        $col_date = BLOG_DATE;
        $col_title = BLOG_TITLE;
        $col_text = BLOG_TEXT;

        $number_of_cols = BLOG_NUM_COLS;

        function prepare_string($string){
            $content = htmlspecialchars_decode($string);
            $content = str_replace('<br />', "\n", $content);
            return htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        }

        // connect to db
        $link_ownStuff = ConnectDB::connect(ISONAPACHE, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");

        if (mysqli_connect_error()){
            die("Connection Error: Something went wrong, blame the programmer");
        }

        $query = "SELECT * FROM $table_name ORDER BY $col_postId DESC;";

        $result = mysqli_query($link_ownStuff, $query);

        $blogPosts = "";

        while($row = mysqli_fetch_array($result)){
            $date = htmlspecialchars($row[1]);
            //reformat date
            $date = DateTime::createFromFormat('Y-m-d', $date);
            $date = $date->format('d.m.Y');

            $title = prepare_string($row[2]);

            $text = $row[3];
            $text = prepare_string($row[3]);

            //check if there is a link
            $link = htmlspecialchars($row[4]);

            if(empty($link)){
                $blogPost = '
                <div class="post_container container-fluid bg-dark bg-opacity-75 border border-white mb-3">
                    <h2 class="text-light mb-0">'. $title . '</h2>
                    <p class="dateText mt-0"> - ' . $date . '</p>
                    <pre class="text-light">'. $text . '</pre>
                </div>
            ';
            }else{
                $blogPost = '
                <div class="post_container container-fluid bg-dark bg-opacity-75 border border-white mb-3">
                    <h2 class="text-light mb-0">'. $title . '</h2>
                    <p class="dateText mt-0"> - ' . $date . '</p>
                    <pre class="text-light">'. $text . '</pre>
                    <p><a href="' . $link . '" target="_blank" rel="noopener noreferrer">Link zu Google Photos</a></p>
                </div>
            ';
            }

            echo $blogPost;
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


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
                function submit_form(){
                    document.getElementById("form_password").submit();
                }
                
                
            }
        }); 

    </script>

</body>



</html>
