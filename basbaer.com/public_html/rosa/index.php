<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danke</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Blaka&display=swap" rel="stylesheet"> 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" >

    <style>
        body {

            font-family: 'M PLUS 1 Code', sans-serif;
            align-items: center;
            margin: 0;
           /* overflow-x: hidden; *//* no scrolling is possible */
            overflow-y: hidden;
            
        }

        h2 {
            text-align:center;
           /* margin-top: 30vh;*/
            margin-top: 10vh;
            margin-bottom: 10vh;
            font-size:x-large;
            font-family: 'Bebas Neue', cursive;
        }

        p {
            text-align:center;
            font-size:large;
            font-family: 'Blaka', serif;
        }

    </style>
</head>

    <body>

    </body>


</html>


<?php
$error = "";

$table_name = "Lyrics";
$col_lyric = "lyric";
$col_song = "song";
$col_artist = "artist";
$col_link = "link";
$col_times_shown = "times_shown";
$col_last_shown = "last_shown";

//------------------------------ FUNCTIONS ------------------------------------------------------
function get_row_of_the_day(){
    global $table_name, $col_last_shown,$link, $col_times_shown;
    //get lyric of the day:
    // where last shown is today 
    // if there is no one, choose one where last_shown is null
    // if there is no one, choose one where the times_shown is minimal

    $today = date_create(date("Y-m-d"));

    // -1 because monday is 1
    $weekday = date("N") - 1;

    $monday_of_week = date_sub($today, date_interval_create_from_date_string($weekday." days"));

    $monday = $monday_of_week->format("Y-m-d");

    $query = "SELECT * FROM $table_name WHERE ".$col_last_shown." = '".$monday."' LIMIT 1";

    $result = mysqli_query($link, $query);

    $row = "";

    //check if result is empty
    if (mysqli_num_rows($result) == 0){
        //get one where last_shown is NULL
        $query = "SELECT * FROM $table_name WHERE ".$col_last_shown." IS NULL LIMIT 1";
        
        $result =  mysqli_query($link, $query);

        if(mysqli_num_rows($result) == 0){
            //get the one with min times_shown
            $query = "SELECT * FROM $table_name WHERE ".$col_last_shown." = (SELECT MIN(".$col_last_shown.") FROM $table_name) LIMIT 1";

            $result = mysqli_query($link, $query);
            
        }

        $row = mysqli_fetch_array($result);
        
        //update the last shown value
        $query = "UPDATE ".$table_name." SET ".$col_last_shown." = '".$monday."' WHERE id = ".$row['id']." LIMIT 1; ";

        $result = mysqli_query($link, $query);

        //update the times shown value
        $times = $row[$col_times_shown] + 1;

        $query = "UPDATE ".$table_name." SET ".$col_times_shown." = '".$times."' WHERE id = ".$row['id']." LIMIT 1; ";

        $result = mysqli_query($link, $query);
        

    }else{
        $row = mysqli_fetch_array($result);
    }

    return $row;

}

//------------------------------ End FUNCTIONS ---------------------------------------------------

//todo
// Enter zeichen
// get one which min times_shown

//get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
//Note: the password does not contain special characters
//$link = mysqli_connect("mysql.stackcp.com", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b", "58626");
#$link = mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");

//this line is needed to display special characters properly
#$link->query("SET NAMES 'utf8'");

// this will echo nothing if there is no error
#if (mysqli_connect_error()){
#    die("Connection Error: Maybe the password contains special characters");
#}

#$row = get_row_of_the_day();

#$spotify_link = $row[$col_link];

// $page = '<div class="container-fluid align-items-center">
//             <div class="container align-items-center">
//                 <h1 id="lyric" onclick="open_spotify()">"'.$row[$col_lyric].'"</h1>
//             </div>
//             <div class="container align-items-center">
//                 <p>- aus "'.$row[$col_song].'" von '.$row[$col_artist].'</p>
//             </div>
//         </div>
//         ';

$fixText = "Hey, Rosa.
Ich wollte dir noch einmal 'Danke' sagen. Die eineinhalb Jahre waren für mich eine wunderschöne Zeit. Ich bin dankbar für all die unvergesslichen Momente, die wir zusammen erleben durften. Du bist und bleibst ein toller Mensch und ich weiß es sehr zu schätzen, dass wir einen Teil unsers Lebens auf so eine enge,intime Weise verbringen konnten. Ich weiß es auch zu schätzen, wie sehr du mich geliebt und um uns gekämpft hast. Es tut mir leid, dass ich das gegen Ende nicht getan habe. Du hast so etwas nicht verdient. Es tut mir leid, dass ich mich nicht besser öffnen konnte und den Rückzug gesucht habe. Es tut mir leid, dass ich nicht so für dich da sein konnte, wie ich es mir von mir selbst gewünscht hätte.
Ich habe durch dich und unsere Beziehung sehr viel über mich und das Leben gelernt. Ich bin sehr dankbar über die vielfältigen Situationen, in denen du mir neue Perspektiven gezeigt hast und mich zu einem besseren Menschen gemacht hast.
Für mich bleibst du immer ein besonderer Mensch, zu dem ich eine besondere Verbinung habe.";

$page = '<div class="container-fluid align-items-center">
            <div class="container align-items-center">
                <h2 id="lyric">'.$fixText.'</h2>
            </div>
            
        ';




echo $page;




?>


<script>
        function open_spotify(link) {
            window.open("<?php echo $spotify_link;?>")
        }
</script>
