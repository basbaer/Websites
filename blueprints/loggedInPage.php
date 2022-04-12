<?php

session_start();

if(array_key_exists("id", $_COOKIE)){
    $_SESSION['id'] = $_COOKIE['id'];
}

if(array_key_exists('id', $_SESSION)){
    echo "<p> You are logged in! <a href='logIn.php?logout=1'>Log out?</a></p>";

    print_r($_COOKIE);

    echo "<br>";

    print_r($_SESSION);

    echo "<br>";

    echo $error;

}else{

    header("Location: logIn.php");
}


?>