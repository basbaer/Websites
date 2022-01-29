<?php

    $error .= "";

    session_start();

    if(array_key_exists('admin', $_SESSION)){
        //this part is for all users (the only admin part is below)

        //some variables
        $table_name = "Festivals";
        $col_name= "name";
        $col_start= "start";
        $col_end= "end";
        $col_overlap= "overlap";
        $col_loc= "location";
        $col_tic= "tickets";
        $col_inf= "info";
        $col_basti= "Basti-Score";
        $number_of_cols = 9;

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
        $table .= "<div id='bg_wrap' class='container-fluid align-items-center d-flex'>";
        $table .="<div class='container-md'><table class='table table-dark table-striped'>
                <thead>
                <tr>
                    <th scope='col'>Festival</th>
                    <th scope='col'>Start</th>
                    <th scope='col'>End</th>
                    <th scope='col'>Location</th>
                    <th scope='col'>Tickets</th>
                    <th scope='col'>Infos</th>
                    <th scope='col'>Basti-Score</th>
                </tr>
                <thead><tbody>";
        
        //indizies
        $ov_ind = 4;
        $tic_ind = 6;
        $bas_ind = 8;

        while($row = mysqli_fetch_array($result)){

            $table = $table."<tr>";

            for ($i = 1; $i < $number_of_cols; $i++){
                //skip the overlap colum
                if($i != $ov_ind){
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
                    if($i == $tic_ind){
                        //check if it's a link
                        if(substr_count($output, 'http')){
                            $output = "<a href='".$output."'>hier</a>";
                        }
                    }

                    //start new row
                    if ($i == 1){
                        $table .= "<th scope='row'>".$output."</th>";
                    }else{
                        //here will the classes be added
                        $class = " class='";

                        $table = $table."<td";
                        //change color if overlap
                        if($row[$ov_ind] == '1' && ($i == 2 || $i == 3)){
                            $class .= "red_font";
                        }

                        //center text of basti-score column
                        if($i == $bas_ind) {
                            $class .= " text-center";
                        }

                        $class .= "'";
                        
                        
                        $table .= $class.">".$output."</td>";

                        

                    }



                }
            }

            $table = $table."</tr>";
 
        }

        $table = $table."</tbody></table></div></div>";

        echo $table;

        if($_SESSION['admin'] == '1'){
            echo "<a href='addFestival.php'>Add festival</a>";
        }

        

    }else{
        $error .= "No key 'admin' in SESSSION VARIABLE<br>";
    }

    //echo $error;

?>

<html>

<head>

<meta charset="utf-8" />

<title>Festivals</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&display=swap" rel="stylesheet"> 

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


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

        #logIn{
            width:100%;
            text-align:center;
            margin: 50px;
        }

        #bg_wrap{
            background-image: url("pictures/stars.jpg");
            height:100%;
        }

    </style>


</head>

<body>




</body>

</html>
