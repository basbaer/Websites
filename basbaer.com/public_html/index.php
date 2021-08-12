<?php

if ($_POST) {

    $error = "";

    if (!$_POST["mail"]){

        $error .= "An email address is required <br>";


    }

    

    if (!$_POST["InputSubject"]){

        $error .= "The Suject field is required <br>";

    }

    if (!$_POST["InputBody"]){

        $error .= "The text field is required <br>";

    }

    if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
        $error .= "Invalid email format";
    }


    if ($error != ""){
        $error = '<div class="container"><div class="alert alert-danger col-md-6 my-3" role="alert">
        <h4 class="alert-heading">There are some errors!</h4>
  <p>'.$error.'</p></div></div>';

        echo $error;
    }else{

        $emailTo = "";

        $subject = $_POST["InputSubject"];

        $body = $_POST["InputBody"];

        $headers = "From: ".$_POST["mail"];



        if (mail($emailTo, $subject, $body, $headers)){

            echo '<div class="container">
                    <div class="alert alert-success col-md-6 my-3" role="alert">
                        <h4 class="alert-heading">Anfrage wurde gesendet</h4>
                    </div>
                </div>';

        }else{
            echo '<div class="container">
            <div class="alert alert-attention col-md-6 my-3" role="alert">
                <h4 class="alert-heading">Anfrage wurde nicht gesendet (Server-Fehler)</h4>
            </div>
        </div>';
        }


        


    }




}




?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Contact Form</title>
  </head>



  <body>


    

    <div class="container">

        <h1>Kontaktiere uns!</h1>

        <form class="needs-validation" method="post" novalidate>

            <div class="col-md-6 mb-3 has-validation">
                <label for="InputEmail" class="form-label">Email Adresse</label>
                <input type="email" class="form-control" id="InputEmail" name="mail" aria-describedby="emailHelp" required>
                <div class="invalid-feedback">
                    Bitte gib eine gültige E-Mail-Adresse ein.
                </div>

                <div id="emailHelp" class="form-text">Die Mailaddresse wird mit niemandem geteilt</div>

                
          

             
            </div>

            <div class="col-md-6 mb-3">

                <label for="InputSubject" class="form-label">Betreff</label>
                <input type="text" class="form-control" name="InputSubject" id="InputSubject" required>
                <div class="invalid-feedback">
                    Bitte gib einen Betreff an.
                </div>



            </div>

            <div class="col-md-6 mb-3">

                <label for="InputBody" class="form-label">Deine Nachricht</label>
                <textarea class="form-control" id="InputBody" name="InputBody" rows="4" required></textarea>
                <div class="invalid-feedback">
                    Bitte teile uns mit, warum die die Anfrage schickst.
                </div>



            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Anfrage absenden!</button>
            </div>

        </form>




    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

   <script type="text/javascript">

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
            })
        })()


   </script>
  </body>
</html>