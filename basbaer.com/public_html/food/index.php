<?php
$ENCRYPTION_ALGORITHM = 'aes-256-cbc';

// BEGIN FUNCTIONS ***************************************************************** 
function Encrypt($ClearTextData, $encryption_key) {
    // This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
    // The initialization vector (IV) is appended to the cipher data with 
    // the use of two colons serve to delimited between the two.
    global $ENCRYPTION_ALGORITHM;

    if (in_array($ENCRYPTION_ALGORITHM, openssl_get_cipher_methods()))
    {
        $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));

        $EncryptionKey = base64_decode($encryption_key);

        $EncryptedText = openssl_encrypt($ClearTextData, $ENCRYPTION_ALGORITHM, $EncryptionKey, $options=0, $InitializationVector);


    }

    return base64_encode($EncryptedText . '::' . $InitializationVector);
}


function Decrypt($CipherData, $encryption_key) {
    // This function decrypts the cipher data (with the IV embedded within) passed into it 
    // and returns the clear text (unencrypted) data.
    // The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
    // There are two colons that serve to delimited between the cipher data and the IV.
    global $ENCRYPTION_ALGORITHM;

    if (in_array($ENCRYPTION_ALGORITHM, openssl_get_cipher_methods()))
    {
        $EncryptionKey = base64_decode($encryption_key);
        list($Encrypted_Data, $InitializationVector) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
        return openssl_decrypt($Encrypted_Data, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
    
    }   
}

// END FUNCTIONS ***************************************************************** 

    $error = "";

    session_start();

    //only for testing ########################################
    $_SESSION['admin'] = 1;
    $_SESSION['password']= "Password";
    

    //End Testing ##############################################

    if(array_key_exists('admin', $_SESSION)){
        //only for admins
        if($_SESSION['admin'] == '1'){
            //echo "<a href='addFood.php'>Add food</a>";

            $pass = $_SESSION['password'];

            //db variables
            $table_food= "Food";
            $col_mealId= "mealId";
            $col_meal= "meal";
            $col_eatenAt= "eatenat";
            $col_amount= "amount";

            $number_of_cols = 5;


            //get the server and the db name (db name and username are the same) from the stack cp control panel > MySQL Databases
            //Note: the password does not contain special characters
            //$link_food = mysqli_connect("mysql.stackcp.com", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b", "58626");
            $link_food = mysqli_connect("shareddb-s.hosting.stackcp.net", "ownstuffdb-313235581b", "lOdyA4LhqQD", "ownstuffdb-313235581b");

            //this line is needed to display special characters properly
            $link_food->query("SET NAMES 'utf8'");


            // this will echo nothing if there is no error
            if (mysqli_connect_error()){
                die("Connection Error: Maybe the password contains special characters");
            }

            //table that shows when the meals were eaten last
            $query = "SELECT $col_meal, MAX($col_eatenAt), $col_amount FROM $table_food GROUP BY $col_mealId";

            $result = mysqli_query($link_food, $query);

            //create table
            $table = "<div id='bg_wrap' class='container-fluid align-items-center d-flex'>";
            $table .="<div class='container-md'><table class='table table-dark table-striped'>
                    <thead>
                    <tr>
                        <th scope='col'>Meal</th>
                        <th scope='col'>Date</th>
                        <th scope='col'>Days ago</th>
                        <th scope='col'>Amount</th>
                    </tr>
                    </thead><tbody>";
            
            //indizies
            $meal_i= 0;
            $eatenAt_i = 1; 
            $amount_i= 2;

            while($row = mysqli_fetch_array($result)){

                $table = $table."<tr>";

                for ($i = 0; $i < 3; $i++){

                    $output = $row[$i];

                    //format date correctly
                    if ($i == $eatenAt_i){
                        //handle festivals without a date
                        if ($output == "0000-00-00"){
                            $output = "";
                        }else{
                            //right date format
                            $date = date_create($output);
                            $output = date_format($date, "d.m.y");

                            //calc daysAgo
                            $last_done = date_create($row[$eatenAt_i]);
                            $today= date_create("today");
                            $diff= date_diff($last_done, $today)->format('%a');

                            $output .= "</td><td>".$diff;


                        }
        
                    }

                
                    if(is_null($output)){
                        $output = "";
                    }
                    

                    //start new row
                    if ($i == 0){
                        $table .= "<th scope='row'>".$output."</th>";
                    }else{

                        $table .= "<td>".$output."</td>";
                    }
                
                }

                $table = $table."</tr>";
    
            }

            $table .= "</tbody></table></div></div>";

            echo $table;

        }  

    }else{
        $error .= "No key 'admin' in SESSSION VARIABLE<br>";
    }

    echo $error;

?>

<html>

<head>

<meta charset="utf-8" />

<title>Food</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&display=swap" rel="stylesheet"> 

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


    <style type="text/css">

        table {
            font-family: 'Syne Mono', monospace;
            margin-bottom: 20px;

        }

        td {
            padding: 10px;
        }

        tr:nth-child(even) {
                background-color: #D6EEEE;
            }

        .red_font{
            color:red;
        }

        .hiddenAtStart {
            display: none;
        }

        #logIn{
            width:100%;
            text-align:center;
            margin: 50px;
        }

        #bg_wrap{
            background-image: url("pictures/stars.jpg");
            height:100%;
        }

    </style>


</head>

<body>




</body>

</html>
