<?php


?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>DJ Rubin | Booking & Kontakt</title>

    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="icon" href="pictures/Logo/DJR_Aufkleber_weiß_oS_oH_scaled.png" type="image/icon type">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script src="https://www.google.com/recaptcha/api.js?render=6LfIhssiAAAAAOvAWGXlrATx5wvPKOeH0IEdJsXv"></script>


</head>



<body>

    <!--Navbar-->

    <!--navbar-expand-md: over which width the navbar expands-->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark fixed-top" id="navbar">

        <div class="container-xl">

            <a class="navbar-brand" href="index.html">
                <img src="pictures/Logo/DJR_Aufkleber_weiß_oS_oH.png" id="navbar_logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="dj&Technik.html">DJ & Technik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="explosion.html">The Explosion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="booking.php">Booking & Kontakt</a>
                    </li>


                </ul>

            </div>

        </div>

    </nav>


    <div class="container py-5 container_after_navbar">

        <h1>Kontaktier mich!</h1>

        <form class="needs-validation" method="post" novalidate id="submitForm" action="form_submitted.php" onSubmit="return validatForm()">

            <div class="col-md-6 mb-3 has-validation">

                <label for="InputEmail" class="form-label">Deine E-Mail</label>

                <input type="email" class="form-control" id="InputEmail" name="mail" aria-describedby="emailHelp" required>
                <div class="invalid-feedback">
                    Bitte gib eine gültige E-Mail-Adresse ein.
                </div>

                <div id="emailHelp" class="form-text">Deine E-Mail Adresse wird lediglich zur Kontaktaufnahme verwendet</div>

            </div>

            <div class="col-md-6 mb-3">

                <label for="InputName" class="form-label">Name/Organisation</label>
                <input type="text" class="form-control" name="InputName" id="InputName" required>
                <div class="invalid-feedback">
                    Bitte gib an, wer du bist.
                </div>



            </div>

            <div class="col-md-6 mb-3">

                <label for="InputBody" class="form-label">Deine Nachricht</label>
                <textarea class="form-control" id="InputBody" name="InputBody" rows="4" required></textarea>
                <div class="invalid-feedback">
                    Bitte teile uns mit, warum du die Anfrage schickst.
                </div>



            </div>

            <div class="col-12">
                <button class="btn btn-dark" value="submit" type="submit">Anfrage absenden!</button>
            </div>

        </form>

        <script>
            function validateForm(){
                var emails_fmt =  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                let email = document.forms["submitForm"]["mail"].value;
                let name = document.forms["submitForm"]["InputName"].value;
                let body = document.forms["submitForm"]["InputBody"].value;
                if (email == "") {
                    return false;
                } else if (!(email.match(emails_fmt))){
                    return false;
                } else if (name == ""){
                    return false;
                } else if (body == ""){
                    return false;
                }
            }

            $('#submitForm').submit(function(event) {
                event.preventDefault();
                var email = $('#InputEmail').val();
                var subject = $('#InputName').val();
                var body = $('#InputBody').val();

                grecaptcha.ready(function() {
                    grecaptcha.execute('6LfIhssiAAAAAOvAWGXlrATx5wvPKOeH0IEdJsXv', {
                        action: 'submit'
                    }).then(function(token) {
                        $('#submitForm').prepend('<input type="hidden" name="token" value="' + token + '">');
                        $('#submitForm').prepend('<input type="hidden" name="action" value="submit">');
                        $('#submitForm').unbind('submit').submit();
                    });;
                });
            });
        </script>




    </div>




    <!--Footer-->
    <footer>
        <hr class="mt-5">

        <div class="container mb-5">

            <div class="row">

                <div class="col-4 d-flex justify-content-start">
                    <div class="my-auto mx-auto">
                        <a href="https://www.instagram.com/dj_rubin_official/" target="_blank">
                            <img src="pictures/Icons/Instagram_icon.png" class="icon">
                        </a>
                    </div>
                    <div class="my-auto mx-auto">
                        <a href="https://www.facebook.com/rubinDJ/" target="_blank">
                            <img src="pictures/Icons/facebook_icon.png" class="icon">
                        </a>
                    </div>

                    <div class="my-auto mx-auto">
                        <a href="https://soundcloud.com/user-999693809-597950715" target="_blank">
                            <img src="pictures/Icons/soundcloud.png" class="icon">
                        </a>
                    </div>

                    <div class="my-auto mx-auto">
                        <a href="mailto: dj_rubin_official@outlook.de">
                            <img src="pictures/Icons/mail.svg" class="icon">
                        </a>
                    </div>


                </div>

                <div class="col-8 text-end my-auto" id="footer_text">
                    <a href="datenschutz.html" class="footer_link">Datenschutz</a> | <a href="impressum.html" class="footer_link">Impressum</a>
                </div>

            </div>

        </div>

    </footer>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <script type="text/javascript">
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
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