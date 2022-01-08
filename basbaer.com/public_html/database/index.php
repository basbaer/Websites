<?php
    //some variables
    $table = "Festivals";
    $col_name= "name";
    $col_start= "start";
    $col_end= "end";
    $col_loc= "location";
    $col_tic= "tickets";
    $col_inf= "info";

    //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");

    //this line is needed to display special characters properly
    $link->query("SET NAMES 'utf8'");

    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        die("Connection Error: Maybe the password contains special characters");
    }

    $query = "SELECT * FROM $table";

    $result = mysqli_query($link, $query);

    //create table
    $table ="<table>
            <tr>
                <th>Festival</th>
                <th>Start</th>
                <th>End</th>
                <th>Location</th>
                <th>Tickets</th>
                <th>Infos</th>
            </tr>";

    while($row = mysqli_fetch_array($result)){

        $table = $table."<tr>";

        for ($i = 1; $i < 7; $i++){

            $output = $row[$i];

            //formate date correctly
            if ($i == 2 || $i == 3){
                $date = date_create($output);
                $output = date_format($date, "d.m.");
            }

            $table = $table."<td>".$output."</td>";
            
            
        }

        $table = $table."</tr>";

    
        

    }

    $table = $table."</table>";

    echo $table;

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

        //check if festival already exists
        $query = "SELECT id FROM $table WHERE $col_name = '".mysqli_real_escape_string($link, $name)."';";

        $result = mysqli_query($link, $query);

        //Festival is alread in db
        if (mysqli_num_rows($result) > 0){
            echo "Oops this festival is already in the database";
            
        }else{
            //Festival is not in db
            //Add the festival
            $insert = "INSERT INTO $table (id, $col_name, $col_start, $col_end, $col_loc, $col_tic, $col_inf) VALUES (NULL, '"
            .mysqli_real_escape_string($link, $name)."', '"
            .mysqli_real_escape_string($link, $start)."', '"
            .mysqli_real_escape_string($link, $end)."', '"
            .mysqli_real_escape_string($link, $loc)."', '"
            .mysqli_real_escape_string($link, $tic)."', '"
            .mysqli_real_escape_string($link, $inf)."')";

            if(mysqli_query($link, $insert)){
                echo "Festival added succesful";
            } else {
                echo "Festival could not be added";
            }


        }




    }

    //password db: lOdyA4LhqQD





?>

<html>

<head>

<meta charset="utf-8" />

<title>Festivals</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&display=swap" rel="stylesheet"> 

    <style type="text/css">

        table {
            font-family: 'Syne Mono', monospace;
            margin-bottom: 20px;

        }

        td {
            padding: 10px;
        }

        tr:nth-child(even) {
                background-color: #D6EEEE;
            }

    </style>


</head>

<body>


<form method = "post">

    <input name="name" type="text" placeholder="Festival name">

    <input name="start" type="date" placeholder="starting date">

    <input name="end" type="date" placeholder="end date">

    <input name="location" type="text" placeholder="location">

    <input name="tickets" type="text" placeholder="tickets">

    <input name="info" type="text" placeholder="additional infos">

    <input type="submit" value="Add entry">
    

</form>


</body>



</html>

to do:
change date appearance
change color if the same date
order by date 