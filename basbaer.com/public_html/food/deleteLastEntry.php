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
$col_foodId = "id";

//Food_Units table variables
$table_units = "Food_Units";
$col_unit = "unit";

$number_of_cols = 5;

$link_ownStuff = ConnectDB::connect($isLocalhost, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'deleteLastEntry') {
      // double secure
      delete_last_entry();
    }
}



function delete_last_entry()
{
    global $link_ownStuff, $table_food, $col_foodId, $password;

    $error = "";

    //Delete Entry
    $query = "DELETE FROM $table_food  WHERE $col_foodId = (SELECT MAX($col_foodId) FROM $table_food) LIMIT 1";
    $result = mysqli_query($link_ownStuff, $query);

    header("Location: index.html");
        
    exit;

}
