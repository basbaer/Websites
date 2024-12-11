<?php

session_start();

$table_logIn = "FestivalLogIn";
$col_id = "id";
$col_pass = "password";
$col_admin = "admin";

//get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
//Note: the password does not contain special characters
$link = mysqli_connect("sdb-f.hosting.stackcp.net", "logInDb-3138340968", "ud0uz58bam", "logInDb-3138340968");
//$link = mysqli_connect("mysql.stackcp.com", "logInDb-3138340968", "ud0uz58bam", "logInDb-3138340968", "58438");

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


                    ?>

                    <script type="text/javascript">
                        window.location = "http://basbaer.com/food";
                    </script>

                    <?php 
                    
                    exit();

                }else{

                    $error.= "password does not match<br>";
                }
            }

            // no matching password
            ?>

            <script type="text/javascript">
                        window.location = "http://basbaer.com/";

                        
            </script>

            <?php
            
        }

    }else{
        $error .= "No password in POST";
    }

      
}else{
    $error .= "No POST variable<br>";
}

if (isset($error)){
    //echo $error;
}


?>