<?php
    //redirect users that enter over url
    session_start();
    require_once "../config.php";
    //redirect users that are not logged in to starting page
    if (!$_SESSION['password']){
        header('Location: http://' .  $_SERVER['HTTP_HOST']);
        exit;
    }
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

    <!-- Install jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">



    <style>
        body {

            font-family: 'M PLUS 1 Code', sans-serif;
            background-image: url("pictures/stars.jpg");
            background-size: cover;
            margin: 0;
            /*overflow-x: hidden;
             no scrolling is possible 
            overflow-y: hidden;*/

        }

        table {
            font-family: 'Syne Mono', monospace;
            margin-bottom: 20px;
            margin-top: 10vh;

        }

        td {
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: #D6EEEE;
        }
    </style>

</head>

<body>

    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
                
            <button class="btn btn-outline-light" type="button" id="homeButton">Home</button>
                   
            <button class="btn btn-outline-success ms-auto" type="button" id="blogButton">Blog</button>
                   
        </div>
    </nav>



    <script>
    document.getElementById('blogButton').addEventListener('click', function() {
            window.location.href = '/blog';
    });

    document.getElementById('homeButton').addEventListener('click', function() {
        window.location.href = '/';
    });
    </script>

    <div class='container-sm mb-4'>
        <table class='table table-dark table-striped' id="mealTable">
            <thead>
                <tr>
                    <th scope='col'>Meal</th>
                    <th scope='col'>Date</th>
                    <th scope='col'>Days ago</th>
                    <th scope='col'>Amount</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


        <!--Form-->
        <form method="post" action="addMeal.php">
            <div class="row ">
                <div class="col-sm-3 mb-2">
                    <select class="form-select" id="selectMeal" onChange="updateUnit(this.selectedIndex);" name="meal" required>
                    </select>
                </div>
            
                <div class="col-sm-3 text-center mb-2">
                    <input type="date" class="form-control" name="date">
                </div>

                <div class="col-sm-2  mb-2">
                    <input type="text" class="form-control" placeholder="amount" name="amount">
                </div>

                <div class="col-sm-2 mb-2">
                    <select class="form-select" id="unit" name="unit"></select>
                </div>

                <div class="col-sm-2 mb-4">
                    <button class="btn btn-dark" type="submit" name="action" value="addMeal">Submit</button>
                </div>

            </div>
        
        </form>



        <form action="deleteLastEntry.php" method="post">
            <button type="submit" name="action" value="deleteLastEntry" class="btn btn-danger">Delete last entry</button>
        </form>
          

        



        <script src="index.js"></script>
        <script type="text/javascript">
            getTable();
        </script>

        

    </div>


    </div>




</body>

</html>