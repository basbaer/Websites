<?php

include "Crypto.php";
include "ConnectDB.php";



###################### ADD INFORMATION HERE ###############################################
$isLocalhost = false;
$password = "";
##########################################################################################
if(!$_SESSION) {
    session_start();
}

if(array_key_exists('admin', $_SESSION)){
    //only for admins
    if($_SESSION['admin'] == '1'){
        $password = $_SESSION['password'];
    }

}else{
    $error .= "No key 'admin' in SESSSION VARIABLE<br>";
}


//db variables
//food table
$table_food= "Food";
$col_mealId= "mealId";
$col_meal= "meal";
$col_eatenAt= "eatenat";
$col_amount= "amount";
$col_unit="unit";

//Food_Units table variables
$table_units = "Food_Units";
$col_unit = "unit";

$number_of_cols = 5;

$link_ownStuff = ConnectDB::connect($isLocalhost, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");



function build_table(){
    global $link_ownStuff, $table_food, $col_mealId, $col_meal, $col_eatenAt, $col_amount, $col_unit, $error, $password;


    //table that shows when the meals were eaten last

    //get the id of the latest entry of every meal
    $query = "SELECT $col_mealId, MAX($col_eatenAt) FROM $table_food GROUP BY $col_mealId";

    $result = mysqli_query($link_ownStuff, $query);

    //create json format of table
    //
    
    $table= [];


    while($row = mysqli_fetch_array($result)){

        //make query to get the latest row
        $id = $row[0];
        $d = $row[1];

        $query = "SELECT $col_meal, $col_eatenAt, $col_amount, $col_unit FROM $table_food WHERE $col_mealId = '$id' AND $col_eatenAt = '$d'";

        $latest_entry_result = mysqli_query($link_ownStuff, $query);

        $r = mysqli_fetch_array($latest_entry_result);

        //indizies
        $meal_i= 0;
        $eatenAt_i = 1;
        $amount_i= 2;
        $unit_i= 3;

        //manipulate all data right
        //meal
        $meal = Crypto::decrypt($r[$meal_i], $password);

       //format date correctly
        //handle festivals without a date
        $date= "";
        $daysago= "";
        if ($r[$eatenAt_i] != "0000-00-00"){

            //right date format
            $date = date_create($r[$eatenAt_i]);
            $date = date_format($date, "d.m.y");

            //calc daysAgo
            $last_done = date_create($r[$eatenAt_i]);
            $today= date_create("today");
            $diff= date_diff($last_done, $today)->format('%a');

            $daysago= $diff;

        }

        $amount= "";
        if(!is_null($r[$amount_i])){
            $amount= $r[$amount_i];
            if(!is_null($r[$unit_i])){
                $unit = Crypto::decrypt($r[$unit_i], $password);
                $amount .= " $unit";
            }
        }

        $table[$id] = Array (
            "meal" => $meal,
            "date" => $date,
            "daysAgo" => $daysago,
            "amount" => $amount
        );
        

    }

    echo json_encode($table);
}

function get_Unit($id)
{
    global $password, $link_ownStuff;
    
    $id = (int) $id;
    
    //Food_Units table variables
    $table_units = "Food_Units";
    $col_unit = "unit";
    $col_mealId = "mealId";

    $query= "SELECT $col_unit FROM $table_units WHERE $col_mealId = '$id';";

    $result = mysqli_query($link_ownStuff, $query);

    $output = "";

    while($row = mysqli_fetch_array($result)){
        $unit_decry = Crypto::decrypt($row[0], $password);
        $output.= $unit_decry.";";
    }

    //remove last ';'
    $output = substr($output, 0, -1);


    //if something went wrong, it will return -1
    echo $output;
}




// END FUNCTIONS ***************************************************************** 
$error = "";

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    
    $bool = strstr($action, 'getUnits');
    if ($bool) {
        $id= substr($action, 8);
        $action= 'getUnits';
    }
    
    
    switch($action) {
        case 'getTable': 
            build_table();
            unset($_POST["action"]);
            break;
        case 'getUnits': 
            get_Unit($id);
            break;
        case 'addMeal':
            add_Meal();
            break;
        default: 
            echo "wrong action parameter";
    }
}



?>