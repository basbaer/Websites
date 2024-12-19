<?php
session_start();

require_once '../config.php';

//redirect users that are not logged in to starting page
if (!$_SESSION['password']){
    header('Location: http://' .  $_SERVER['HTTP_HOST']);
    exit;
}
?>

<!DOCTYPE html>
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

        #blogInput {
            background-color: #4f2aa8;
            border-radius: 10px;
        }
    </style>

</head>

<body class="bg-dark">
        <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="btn btn-outline-light" type="button" id="homeButton">Home</button>
                <button class="btn btn-outline-success ms-auto" type="button" id="foodButton">FoodDB</button>
            </div>
        </nav>

        <form id="blogInput" class="m-3" action="addPost.php" method="post">
            <div class="container pb-2">
                <div class="mb-3">
                    <label for="datePicker" class="form-label text-light mt-1">Date</label>
                    <input id="datePicker" type="date" class="form-control me-auto" name="date">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label text-light mt-1">Title</label>
                    <input id="title" type="text" class="form-control me-auto" name="title">
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label text-light mt-1">Text</label>
                    <textarea id="text" type="text" class="form-control me-auto" rows="20" name="text"></textarea>
                </div>
                <button id="publishButton" type="submit" name="action" value="addPost" class="btn btn-success">Publish</button>
            </div>
        </form>

        <form class="container-fluid d-flex justify-content-end mb-5" action="deleteLastEntry.php" method="post">
            <button id="removeLastEntryButton" type="submit" class="btn btn-danger me-2 mt-3" name="action" value="deleteLastEntry">Remove last entry</button>
        </div>
        

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datePicker = document.getElementById('datePicker');
            datePicker.valueAsDate = new Date();
        });

        document.getElementById('foodButton').addEventListener('click', function() {
            window.location.href = '/food';
        });

        document.getElementById('homeButton').addEventListener('click', function() {
            window.location.href = '/';
        });
    </script>


</body>
</html>

