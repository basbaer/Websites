<?php

###################### ADD INFORMATION HERE ###############################################
$isLocalhost = false;
$password = $_SESSION['password'];
##########################################################################################


include "Crypto.php";
include "ConnectDB.php";

$error = "";


//db variables
$table_food = "Food";
$col_mealId = "mealId";
$col_meal = "meal";
$col_eatenAt = "eatenat";
$col_amount = "amount";
$number_of_cols = 5;

//Food_Units table variables
$table_units = "Food_Units";
$col_unit = "unit";

if ($password == "") {
    $error .= "no Password \n";
}


$link_food = ConnectDB::connect($isLocalhost, "ownstuffdb-313235581b", "lOdyA4LhqQD", "58626");

$query = "SELECT $col_mealId, $col_meal FROM $table_food GROUP BY $col_mealId ORDER BY $col_mealId";

$result = mysqli_query($link_food, $query);

$form =
    '<div class="row">
        <div class="container-sm mt-3">
            <form method="post">
                <div class="row">
                    <div class="col-3">
                        <select class="form-select" id="selectMeal" onChange="updateUnit(this.selectedIndex);" name="meal" required>';


//get all meals and mealid's
$query = "SELECT $col_mealId, $col_meal FROM $table_food GROUP BY $col_mealId ORDER BY $col_mealId";

$result = mysqli_query($link_food, $query);

$meals = [];

while ($row = mysqli_fetch_array($result)) {

    //decrypt
    $meal_decry = Crypto::decrypt($row[$col_meal], $password);

    $meals[$row[$col_mealId]] = $meal_decry;

    $form .= '<option value="' . $row[$col_mealId] . '"';

    if ($meal_decry == "Weed") {
        $form .= " selected";
    }

    $form .= ">" . $meal_decry . "</option>";
}

$form .=
    '</select>
                    </div>
                    
            
                    <div class="col-3 my-auto text-center">
                        <input type="date" class="form-control" name="date">
                    </div>

                    <div class="col-1 my-auto">
                        <input type="text" class="form-control" placeholder="amount" name="amount">
                    </div>

                    <div class="col-2 my-auto">
                        <select class="form-select" id="unit" name="unit"></select>
                    </div>

                    <div class="col-2">
                        <button class="btn btn-dark" type="submit">Submit</button>
                    </div>
                
                </div>

            </form>

        </div>

    </div>';

echo $form;

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

    <!--Import jQuery (it's also possible to download it to work offline)-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


</head>

<body>

    <script type=text/javascript>
        updateUnit(0);

        function updateUnit(mealId) {
            //make query
            //note: ajax function does not work with 0 as action value

            if (mealId == 0) {
                mealId = "zero";
            }
            $.ajax({
                url: 'getUnit.php',
                data: {
                    action: mealId
                },
                type: 'post',
                success: function(output) {
                    createUnitSelector(output);

                }
            });

            function createUnitSelector(output) {
                //remove all options
                var select = document.getElementById('unit');
        
                while (select.options.length > 0) {
                    select.remove(0);
                }
                

                //output will be all the different units seprated by comma
                units = output.split(";");
                units.forEach(createSelectorOption)

                function createSelectorOption(item) {
                    //add option to the selector
                    var select = document.getElementById('unit');
                    var option = new Option(item, item);

                    select.add(option);
                }
            }
        }

        
    </script>


</body>

</html>