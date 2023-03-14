<?php

class ConnectDB {

    public static function connect($isLocalhost, $databaseName, $databasePassword, $port=NULL){
        /**
         * connects to databases on stackcp
         * 
         * $isLocalhost defines if connection is from the web or from localhost
         * $port is only needed, when connected from localhost
         * 
         * retrun: $link to the database
         */
        //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
        //Note: the password does not contain special characters
        if($isLocalhost){
            if($port != NULL){
                $link = mysqli_connect("mysql.stackcp.com", $databaseName, $databasePassword, $databaseName, $port);
            }
            
        }else{
            $link = mysqli_connect("shareddb-s.hosting.stackcp.net", $databaseName, $databasePassword, $databaseName);
        }
                // this will echo nothing if there is no error
        if (mysqli_connect_error()){
            echo "Error: ".mysqli_connect()."\n";
            die("Connection Error: Maybe the password contains special characters");
        }
        
        //this line is needed to display special characters properly
        $link ->query("SET NAMES 'utf8'");


        return $link;
    }
}

?>