<?php
require_once "../config.php";
include "ConnectDB.php";

session_start();

$table_logIn = "FestivalLogIn";
$col_id = "id";
$col_pass = "password";
$col_admin = "admin";


//get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
//Note: the password does not contain special characters
$link = ConnectDB::connect(ISONAPACHE, "logInDb-3138340968", "ud0uz58bam", "58438", "sdb-f.hosting.stackcp.net");

//this line is needed to display special characters properly
$link->query("SET NAMES 'utf8'");

// this will echo nothing if there is no error
if (mysqli_connect_error()){
    die("Connection Error: Maybe the password contains special characters");
}


if($_POST){

    if($_POST['password']){

        //check if password is correct
        $pass = $_POST['password'];

        $query = "SELECT * FROM $table_logIn";

        $result = mysqli_query($link, $query);

        if(mysqli_num_rows($result) > 0){

            $rows = mysqli_fetch_all($result);
            
            //run over all passwords in the logIn table
            foreach ($rows as $row){

                $pass_index = 1;
                $admin_index = 2;

                //checks if given password is in table
                if (password_verify($pass, $row[$pass_index])) {

                    //1 if the user has admin rights, 0 if not
                    $_SESSION['admin'] = $row[$admin_index];

                    //password is encryption key for database
                    $_SESSION['password'] = $pass;

                    session_write_close();

                    $error .= "row: $row[$admin_index]<br>Session: ".$_SESSION['admin']."<br>";

                    header('Location: http://' .  $_SERVER['HTTP_HOST'] . '/blog');

                    exit;

                }else{

                    $error.= "password does not match<br>";
                }
            }
            
        }

    }else{
        $error .= "No password in POST";
    }

      
}else{
    $error .= "No POST variable<br>";
}

// no matching password
// check if user is already logged in
if (isset($_SESSION["password"])){
    header('Location: http://' .  $_SERVER['HTTP_HOST'] . '/blog');
}else{
    header('Location: http://' .  $_SERVER['HTTP_HOST']);
}

exit;

if (isset($error)){
    //echo $error;
}




?>