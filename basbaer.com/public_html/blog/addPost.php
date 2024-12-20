<?php

include "../util/ConnectDB.php";
require_once "../config.php";

###################### ADD INFORMATION HERE ###############################################
$isLocalhost = ISONAPACHE;
$password = "";
##########################################################################################
//db variables
//Blog table - variables from config.php
$table_name = TABLE_BLOG;
$col_postId = BLOGPOST_ID;
$col_date = BLOG_DATE;
$col_title = BLOG_TITLE;
$col_text = BLOG_TEXT;
$col_link = BLOG_LINK;

$number_of_cols = BLOG_NUM_COLS;

if(!$_SESSION) {
    session_start();
}
if(array_key_exists('admin', $_SESSION)){
    //only for admins
    if($_SESSION['admin'] == '1'){
        $password = $_SESSION['password'];
    }

    $link_ownStuff = ConnectDB::connect($isLocalhost, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action']) && $_POST['action'] == 'addPost') {
        // double secure
            add_Post();
        }
    }

}else{
    $error .= "No key 'admin' in SESSSION VARIABLE<br>";
}



function add_Post()
{
    global $link_ownStuff, $table_name, $col_postId, $col_date, $col_title, $col_text, $col_link;

    $error = "";

    //Get submited values
    //if no date is given, today's date will be passed
    if (empty($_POST['date'])) {
        $date_val = date_create('today');
        $date_val = date_format($date_val, "Y-m-d");
    } else {
        $date_val = $_POST['date'];
    }

    $title_val = $_POST['title'];
    $text_val = $_POST['text'];

    if (empty($_POST['link'])){
        $link_val = NULL;
    }else{
        $link_val = $_POST['link'];
    }

    //input query (if no amount is submitted, it will be NULL)
    $sql = "INSERT INTO $table_name ($col_postId, $col_date, $col_title, $col_text, $col_link) VALUES (NULL, ?, ?, ?, ?)";
    
    $stmt = $link_ownStuff->prepare($sql);
    $stmt->bind_param("ssss", $date_val, $title_val, $text_val, $link_val);
    $stmt->execute();


    $error .= "Query: " . $sql . "<br>";

    unset($_POST);

    if($stmt->errono == 0){
        $error .= "Post added succesful<br>";

        header('Location: http://' .  $_SERVER['HTTP_HOST']);
        
        exit;
    }

    // header('Location: http://' .  $_SERVER['HTTP_HOST']);
        
    // exit;
        
        
    

}
