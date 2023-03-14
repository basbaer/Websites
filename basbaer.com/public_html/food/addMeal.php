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
$table_food = "Food";
$col_mealId = "mealId";
$col_meal = "meal";
$col_eatenAt = "eatenat";
$col_amount = "amount";
$col_unit = "unit";

//Food_Units table variables
$table_units = "Food_Units";
$col_unit = "unit";

$number_of_cols = 5;

$link_ownStuff = ConnectDB::connect($isLocalhost, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");

add_Meal();

function add_Meal()
{
    global $link_ownStuff, $table_food, $col_mealId, $col_meal, $col_eatenAt, $col_amount, $col_unit, $password;

    $error = "";


    //Get submited values
    $meal_concat = $_POST['meal'];
    $str_with_id = strstr($meal_concat,":");
    $mealId_val = substr($str_with_id,1);
    $meal_val = substr($meal_concat, 0, strlen($meal_concat)-(strlen($str_with_id)));

    //encrypt meal
    $meal_encry = Crypto::encrypt($meal_val, $password);
    $meal_val = $meal_encry;
    //if no date is given, today's date will be passed
    if (empty($_POST['date'])) {
        $date_val = date_create('today');
        $date_val = date_format($date_val, "Y-m-d");
    } else {
        $date_val = $_POST['date'];
    }

    //CHECK IF ENTRY ALREADY EXISTS
    $query = "SELECT * FROM $table_food WHERE $col_mealId = '$mealId_val' AND $col_eatenAt = '$date_val' LIMIT 1";
    $result = mysqli_query($link_ownStuff, $query);

    if (mysqli_num_rows($result) != 0) {
        $error .= $query;
        $error .= "Meal already in db <br>";

        echo $error;
    } else {
        //input query (if no amount is submitted, it will be NULL)
        if (empty($_POST['amount'])) {
            $insert = "INSERT INTO $table_food (id, $col_mealId, $col_meal, $col_eatenAt, $col_amount, $col_unit) VALUES (NULL, '$mealId_val', '$meal_val', '$date_val', NULL, NULL)";
        } else {
            $amount_val = (float) $_POST['amount'];
            $unit = Crypto::encrypt($_POST['unit'], $password);
            $insert = "INSERT INTO $table_food (id, $col_mealId, $col_meal, $col_eatenAt, $col_amount, $col_unit) VALUES (NULL, '$mealId_val', '$meal_val', '$date_val', '"
                . mysqli_real_escape_string($link_ownStuff, $amount_val) . "', '$unit')";
        }

        $error .= "Query: " . $insert . "<br>";

        unset($_POST);

         
        if (mysqli_query($link_ownStuff, $insert)) {

            $error .= "Meal added succesful<br>";

            header("Location: index.html");
            
            exit;
        }
        
    }

}
