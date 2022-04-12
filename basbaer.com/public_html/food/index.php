<?php

include "Crypto.php";

//db variables
$table_food= "Food";
$col_mealId= "mealId";
$col_meal= "meal";
$col_eatenAt= "eatenat";
$col_amount= "amount";

$number_of_cols = 5;


//get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
//Note: the password does not contain special characters
//$link_food = mysqli_connect("mysql.stackcp.com", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b", "58626");
$link_food = mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");

//this line is needed to display special characters properly
$link_food->query("SET NAMES 'utf8'");


// this will echo nothing if there is no error
if (mysqli_connect_error()){
    die("Connection Error: Maybe the password contains special characters");
}

// BEGIN FUNCTIONS ***************************************************************** 


function build_table(){
    global $link_food, $table_food, $col_mealId, $col_meal, $col_eatenAt, $col_amount, $number_of_cols, $error;


    //table that shows when the meals were eaten last
    $query = "SELECT $col_meal, MAX($col_eatenAt), $col_amount FROM $table_food GROUP BY $col_mealId";

    $result = mysqli_query($link_food, $query);

    //create table
    
    $table ="<div class='row'>
                <div class='container-md d-flex'><table class='table table-dark table-striped'>
                    <thead>
                    <tr>
                        <th scope='col'>Meal</th>
                        <th scope='col'>Date</th>
                        <th scope='col'>Days ago</th>
                        <th scope='col'>Amount</th>
                    </tr>
                    </thead><tbody>";

    //indizies
    $meal_i= 0;
    $eatenAt_i = 1; 
    $amount_i= 2;

    while($row = mysqli_fetch_array($result)){

        $table = $table."<tr>";

        for ($i = 0; $i < 3; $i++){

            $output = $row[$i];

            if($i == $meal_i){
                //decrypt
                $output = Crypto::decrypt($output, $_SESSION["password"]);
            }

            //format date correctly
            if ($i == $eatenAt_i){
                //handle festivals without a date
                if ($output == "0000-00-00"){
                    $output = "";
                }else{
                    //right date format
                    $date = date_create($output);
                    $output = date_format($date, "d.m.y");

                    //calc daysAgo
                    $last_done = date_create($row[$eatenAt_i]);
                    $today= date_create("today");
                    $diff= date_diff($last_done, $today)->format('%a');

                    $output .= "</td><td>".$diff;


                }

            }

        
            if(is_null($output)){
                $output = "";
            }
            

            //start new row
            if ($i == 0){
                $table .= "<th scope='row'>".$output."</th>";
            }else{

                $table .= "<td>".$output."</td>";
            }
        
        }

        $table = $table."</tr>";

    }

    $table .= "</tbody></table></div></div>";

    //Note: all code is echoed via the Build_Page() function

    return $table;
}

function build_form(){
    global $link_food, $table_food, $col_mealId, $col_meal, $col_eatenAt, $col_amount, $number_of_cols, $error;

    $form = 
    '<div class="row">
        <div class="container-sm mt-3">
            <form method="post">
                <div class="row">
                    <div class="col-3">
                        <select class="form-select"  name="meal" required>';


    //get all meals and mealid's
    $query= "SELECT $col_mealId, $col_meal FROM $table_food GROUP BY $col_mealId ORDER BY $col_mealId";

    $result = mysqli_query($link_food, $query);

    $meals = [];

    while($row = mysqli_fetch_array($result)){

        //decrypt
        $meal_decry = Crypto::decrypt($row[$col_meal], $_SESSION["password"]);

        $meals[$row[$col_mealId]] = $meal_decry;
        
        $form .= '<option value="'.$row[$col_mealId].'"';

        if($meal_decry == "Weed"){
            $form .= " selected";
        }

        $form .= ">".$meal_decry."</option>";
    }

    $form .= 
                            '</select>
                    </div>
                    
            
                    <div class="col-3 my-auto text-center">
                        <input type="date" class="form-control" name="date">
                    </div>


                    <div class="col-3 my-auto">
                        <input type="text" class="form-control" placeholder="amount" name="amount">
                    </div>

                    <div class="col-2">
                        <button class="btn btn-dark" type="submit">Submit</button>
                    </div>
                
                </div>

            </form>

        </div>

    </div>';

    if($_POST){
        //Get submited values
        $mealId_val= $_POST['meal'];

        //encrypt meal
        $meal_encry = Crypto::encrypt($meals[$_POST['meal']], $_SESSION["password"]);
        $meal_val= $meal_encry;
        //if no date is given, today's date will be passed
        if(empty($_POST['date'])){
            $date_val= date_create('today');
            $date_val= date_format($date_val, "Y-m-d");
        }else{
            $date_val= $_POST['date'];
        }

        //CHECK IF ENTRY ALREADY EXISTS
        //XXX

        //input query (if no amount is submitted, it will be NULL)
        if(empty($_POST['amount'])){
            $insert = "INSERT INTO $table_food (id, $col_mealId, $col_meal, $col_eatenAt, $col_amount) VALUES (NULL, '$mealId_val', '$meal_val', '$date_val', NULL)";
        }else{
            $amount_val= $_POST['amount'];

            $insert = "INSERT INTO $table_food (id, $col_mealId, $col_meal, $col_eatenAt, $col_amount) VALUES (NULL, '$mealId_val', '$meal_val', '$date_val', '"
            .mysqli_real_escape_string($link_food, $amount_val)."')";

        }

        $error .= "Query: ".$insert."<br>";

        if(mysqli_query($link_food, $insert)){
            $error .= "Meal added succesful<br>";

            unset($_POST);

            build_page();
            
        } else {
            $error .= "Meal could not be added<br>";
        }
    }

    return $form;
}


function build_page(){
        //echo code
        $table = build_table();
        $form = build_form();
        $page = "<div id='bg_wrap' class='container-fluid align-items-center d-flex'><div class='container'>".$table.$form."</div></div>";

        echo $page;

}
// END FUNCTIONS ***************************************************************** 

    $error = "";

    session_start();


    include "navbar.html";

    //only for testing ########################################
    
    

    //End Testing ##############################################

    if(array_key_exists('admin', $_SESSION)){
        //only for admins
        if($_SESSION['admin'] == '1'){

            build_page();


        }

    }else{
        $error .= "No key 'admin' in SESSSION VARIABLE<br>";
    }

    echo $error;

?>

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
            background-image: url("pictures/stars.jpg");
            background-size: cover;
            margin: 0;
            overflow-x: hidden; /* no scrolling is possible */
            overflow-y: hidden;
            
        }

        table {
            font-family: 'Syne Mono', monospace;
            margin-bottom: 20px;
            margin-top: 10vh;

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
</body>
</html>


