<?php

    //password db: lOdyA4LhqQD

    //get the server and the db name from the stack cp control panel > MySQL Databases
    //Note: the password does not contain special characters
    mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");
    
    // this will echo nothing if there is no error
    if (mysqli_connect_error()){
        echo "Connection Error: Maybe the password contains special characters";
    } else {
        echo "Connection successful";
    }

?>