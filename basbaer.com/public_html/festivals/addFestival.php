<?php

    $error = "";

    session_start();

    //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");

    //this line is needed to display special characters properly
    $link->query("SET NAMES 'utf8'");

    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        die("Connection Error: Maybe the password contains special characters");
    }

    if($_SESSION['admin'] = '1'){

        if($_POST){

            //some variables
            $table_name = "Festivals";
            $col_name= "name";
            $col_start= "start";
            $col_end= "end";
            $col_overlap= "overlap";
            $col_loc= "location";
            $col_tic= "tickets";
            $col_inf= "info";
            $col_basti = "Basti_Score";
            $number_of_cols = 9;

            //get essential values of inputs
            if ($_POST['name'] == ''){
                echo "You have to add a name";
            }else{

                $name = $_POST['name'];
                $start = $_POST['start'];
                $end = $_POST['end'];
                $loc = $_POST['location'];
                $tic = $_POST['tickets'];
                $inf = $_POST['inf'];
                $basti = $_POST['basti'];

                //check if festival already exists
                $query = "SELECT id FROM $table_name WHERE $col_name = '".mysqli_real_escape_string($link, $name)."';";

                $result = mysqli_query($link, $query);

                //Festival is alread in db
                if (mysqli_num_rows($result) > 0){
                    $error .= "Oops this festival is already in the database<br>";
                    
                }else{
                    //Festival is not in db

                    //reformat the dates
                    $start= date_create($start);
                    $start= date_format($start, "Y-m-d");

                    $end= date_create($end);
                    $end= date_format($end, "Y-m-d");

                    
                    //overlap variable
                    $overlap= 0;
                    //check if there is a overlap with a other festival
                    $query = "SELECT id FROM $table_name WHERE $col_start BETWEEN '".mysqli_real_escape_string($link, $start)."' AND '"
                    .mysqli_real_escape_string($link, $end)."' OR $col_end BETWEEN '".mysqli_real_escape_string($link, $start)."' AND '"
                    .mysqli_real_escape_string($link, $end)."' OR ($col_start < '".mysqli_real_escape_string($link, $start)."' AND $col_end > '"
                    .mysqli_real_escape_string($link, $end)."')";



                    $overlap_festivals = mysqli_query($link, $query);

                    if($overlap_festivals){
                        while($row = mysqli_fetch_array($overlap_festivals)){
                            //change overlap to true
                            $query = "UPDATE $table_name SET $col_overlap = '1' WHERE id = '".$row[0]."' LIMIT 1";
                            mysqli_query($link, $query);
                            $overlap = 1;
                        }
                        
                    }else{
                        $error .= "No overlaps<br>";
                    }

                    //Add the festival
                    $insert = "INSERT INTO $table_name (id, $col_name, $col_start, $col_end, $col_overlap, $col_loc, $col_tic, $col_inf, $col_basti) VALUES (NULL, '"
                    .mysqli_real_escape_string($link, $name)."', '"
                    .mysqli_real_escape_string($link, $start)."', '"
                    .mysqli_real_escape_string($link, $end)."', '"
                    .$overlap."', '"
                    .mysqli_real_escape_string($link, $loc)."', '"
                    .mysqli_real_escape_string($link, $tic)."', '"
                    .mysqli_real_escape_string($link, $inf)."', '"
                    .mysqli_real_escape_string($link, $basti)."')";

                    $error .= "Query: ".$insert."<br>";

                    if(mysqli_query($link, $insert)){
                        $error .= "Festival added succesful<br>";
                    } else {
                        $error .= "Festival could not be added<br>";
                    }

                }

            }

        }else{
            $error .= "No POST Variable<br>";
        }


    }else{
        $error .= "Sorry you're not an admin<br>";
    }

    echo $error;


?>

<html>

<head>
    <meta charset="utf-8" />

    <title>Add Festival</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&display=swap" rel="stylesheet"> 



</head>
<body>

    
    <form method="post" class="hiddenAtStart">

        <input name="name" type="text" placeholder="Festival name">

        <input name="start" type="date" placeholder="starting date">

        <input name="end" type="date" placeholder="end date">

        <input name="location" type="text" placeholder="location">

        <input name="tickets" type="text" placeholder="tickets">

        <input name="info" type="text" placeholder="additional infos">

        <input name="basti" type="int" placeholder="Basti-Score">

        <input type="submit" value="Add entry">
        

    </form>

</body>

</html>