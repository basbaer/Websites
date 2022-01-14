<?php

    if($_SESSION["password"]){
        
        //some variables
        $table_name = "Festivals";
        $col_name= "name";
        $col_start= "start";
        $col_end= "end";
        $col_overlap= "overlap";
        $col_loc= "location";
        $col_tic= "tickets";
        $col_inf= "info";
        $number_of_cols = 8;

        //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
        //Note: the password does not contain special characters
        $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");

        //this line is needed to display special characters properly
        $link->query("SET NAMES 'utf8'");

        // this will echo nothing if there is no error
        if (mysqli_connect_error()){
            die("Connection Error: Maybe the password contains special characters");
        }

        $query = "SELECT * FROM $table_name ORDER BY $col_start";

        $result = mysqli_query($link, $query);

        //create table
        $table ="<table id='fes_table'>
                <tr>
                    <th>Festival</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Location</th>
                    <th>Tickets</th>
                    <th>Infos</th>
                </tr>";
        
        //indizies
        $ov = 4;
        $num_tic = 6;

        while($row = mysqli_fetch_array($result)){

            $table = $table."<tr>";

            for ($i = 1; $i < $number_of_cols; $i++){
                //skip the overlap colum
                if($i != $ov){
                    $output = $row[$i];

                    //format date correctly
                    if ($i == 2 || $i == 3){
                        //handle festivals without a date
                        if ($output == "0000-00-00"){
                            $output = "";
                        }else{
                            //right date format
                            $date = date_create($output);
                            $output = date_format($date, "d.m.");
                        }
        
                    }

                    //format links
                    if($i == $num_tic){
                        //check if it's a link
                        if(substr_count($output, 'http')){
                            $output = "<a href='".$output."'>hier</a>";
                        }
                    }

                    //change color if overlap
                    if($row[$ov] == '1' && ($i == 2 || $i == 3)){
                        $table = $table."<td class='red_font'>".$output."</td>";
                    }else{
                        $table = $table."<td>".$output."</td>";

                    }
        


                }


                
                
            }

            $table = $table."</tr>";

        
            

        }

        $table = $table."</table>";

        echo $table;

        if($_POST){

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
                $query = "SELECT id FROM $table_name WHERE $col_name = '".mysqli_real_escape_string($link, $name)."';";

                $result = mysqli_query($link, $query);

                //Festival is alread in db
                if (mysqli_num_rows($result) > 0){
                    echo "Oops this festival is already in the database";
                    
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
                        echo "no overlaps";
                    }

                    //Add the festival
                    $insert = "INSERT INTO $table_name (id, $col_name, $col_start, $col_end, $col_overlap, $col_loc, $col_tic, $col_inf) VALUES (NULL, '"
                    .mysqli_real_escape_string($link, $name)."', '"
                    .mysqli_real_escape_string($link, $start)."', '"
                    .mysqli_real_escape_string($link, $end)."', '"
                    .$overlap."', '"
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
        }

}



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

        .red_font{
            color:red;
        }

        .hiddenAtStart {
            display: none;
        }

        #fes_table{
            display: none;
        }

        #logIn{
            width:100%;
            text-align:center;
            margin: 50px;
        }

    </style>


</head>

<body>

    <div class="hiddenAtStart">

        <form method="post">

            <input name="name" type="text" placeholder="Festival name">

            <input name="start" type="date" placeholder="starting date">

            <input name="end" type="date" placeholder="end date">

            <input name="location" type="text" placeholder="location">

            <input name="tickets" type="text" placeholder="tickets">

            <input name="info" type="text" placeholder="additional infos">

            <input type="submit" value="Add entry">
            

        </form>

    </div>

    <script type="text/javascript">

        document.getElementById("ButtonLogIn").onclick = function(){
            let input = document.getElementById("passwordLogIn").value;

            if (input == "gogogi"){
                document.getElementById("logIn").style.display = "none"
                document.getElementById("fes_table").style.display = "block"
            }else{
                alert("Wrong password");
            }
            
        }

    </script>



</body>



</html>
