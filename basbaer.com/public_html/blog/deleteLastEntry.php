<?php

include "../util/ConnectDB.php";
require_once "../config.php";

###################### ADD INFORMATION HERE ###############################################
$isLocalhost = ISONAPACHE;
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
//Blog table - variables from config.php
$table_name = TABLE_BLOG;
$col_postId = BLOGPOST_ID;
$col_date = BLOG_DATE;
$col_title = BLOG_TITLE;
$col_text = BLOG_TEXT;

$number_of_cols = BLOG_NUM_COLS;

$link_ownStuff = ConnectDB::connect($isLocalhost, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'deleteLastEntry') {
      // double secure
      delete_last_entry();
    }
}



function delete_last_entry()
{
    global $link_ownStuff, $table_name, $col_postId, $password;

    //Delete Entry
    $query = "DELETE FROM $table_name  WHERE $col_postId= (SELECT MAX($col_postId) FROM $table_name) LIMIT 1";
    $result = mysqli_query($link_ownStuff, $query);

    header('Location: http://' .  $_SERVER['HTTP_HOST']);
    exit;

}


?>