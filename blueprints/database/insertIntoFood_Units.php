<?php

//READ THIS
// Step 1: Fill in the missing information
// Step 2: Copy this file to var/www/html
// Step 3: Make sure, the folder also contains the ConnectDB.php and Crypto.php file
// Step 3: Run 'localhost/instertIntoFood_Units.php' in your webbrowser

include "Crypto.php";
include "ConnectDB.php";

############################ ADD INFORMATION HERE  ###################################################
$isLocalhost = TRUE;
$unitNameInClearText = "";
$idOfMeal= 1;
$passwordForEncryption= "";

#####################################################################################################
$error = "";



//Food_Units table variables
$table_units= "Food_Units";
$col_unit= "unit";


$link_food = ConnectDB::connect($isLocalhost, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");


$units = array(
    Crypto::encrypt($unitNameInClearText, $passwordForEncryption) => $idOfMeal, 

);

foreach($units as $key => $value) {
    $insert= "INSERT INTO $table_units (id, $col_mealId, $col_unit) VALUES (NULL, '$value', '$key')";

    if(mysqli_query($link_food, $insert)){
        $error .= "Unit added succesful<br>";

        
    } else {
        $error .= "Unit could not be added<br>";
    }
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


</head>
<body>


</body>
</html>