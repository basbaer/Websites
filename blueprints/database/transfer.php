<?php

    $error = "";

    //variables
    $table_name_source= "xxx";
    $table_name_target= "xxx";


    //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    $link_source = mysqli_connect('mysql.stackcp.com', 'uploadDb-323037c9db', 'mj0djchui9', 'uploadDb-323037c9db', '57694');

    //this line is needed to display special characters properly
    $link_source->query("SET NAMES 'utf8'");


    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        die("Connection Error: Maybe the password contains special characters");
    }

    $query = "SELECT * FROM $table_name_source";

    $result = mysqli_query($link_upload, $query);

    $link_target = mysqli_connect("mysql.stackcp.com", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b", "58626");
    $link_target->query("SET NAMES 'utf8'");

    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        die("Connection Error: Maybe the password contains special characters");
    }


    while($row = mysqli_fetch_array($result)){
        $col1 = $row[1];
        $col2 = $row[2];
        $col3 = $row[3];
        $insert= "INSERT INTO Food (id, mealId, meal, eatenAt, amount) VALUES (NULL, '$col1', '$col2', '$col3')";

        if(mysqli_query($link_target, $insert)){
            
        } else {
            $error .= "Entry was not added";
        }
        

    }

    echo $error;

?>

<html>

<head>

<meta charset="utf-8" />

<title>Transfer</title>
  


</head>

<body>




</body>

</html>
