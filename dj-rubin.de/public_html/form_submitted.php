<?php

define("RECAPTCHA_V3_SECRET_KEY", '6LfIhssiAAAAAAkRcFPzQLE-DnqsZvNb4FbD5TNh');
session_start();

if (isset($_POST['mail']) && $_POST['mail']) {
    $mail = filter_var($_POST['mail']);
} else {
    // set error message and redirect back to form...
    header('location: booking.php');
    exit;
}

if (isset($_POST['InputName']) && $_POST['InputName']) {
    $name = filter_var($_POST['InputName']);
} else {
    // set error message and redirect back to form...
    header('location: booking.php');
    exit;
}

if (isset($_POST['InputBody']) && $_POST['InputBody']) {
    $body = filter_var($_POST['InputBody']);
} else {
    // set error message and redirect back to form...
    header('location: booking.php');
    exit;
}

if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
    header('location: booking.php');
    exit;
}
  
$token = $_POST['token'];
$action = $_POST['action'];
  
// call curl to POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);
  
// verify the response
if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    // valid submission
    // go ahead and do necessary stuff
    $recipients = array("kontakt@dj-rubin.de", "noah.gohlke@web.de");
    //$recipients = array("bastianbaer@hotmail.de");

    $emailTo = implode(',', $recipients);

    $subject = "Buchungsanfrage von ".$name;

    //PHP_EOL breaks line   
    $body = $_POST["InputBody"].PHP_EOL.PHP_EOL."Absender: ".$_POST["mail"];

    $headers = "From: kontakt@dj-rubin.de";

    mail($emailTo, $subject, $body, $headers);

} else {
    // spam submission
    // show error message
    echo "You are a bot";
}

echo '<div class="container container_after_navbar_spaced">
<div class="alert alert-success col-md-6 my-3" role="alert">
    <h4 class="alert-heading">Anfrage wurde gesendet</h4>
</div>
</div>';



?>

<html lang="en">

<head>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

<title>DJ Rubin | Booking & Kontakt</title>

<link rel="stylesheet" type="text/css" href="style.css">

<link rel="icon" href="pictures/Logo/DJR_Aufkleber_weiß_oS_oH_scaled.png" type="image/icon type">
</head>


<body>

    <!--Navbar-->

    <!--navbar-expand-md: over which width the navbar expands-->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark fixed-top" id="navbar">

        <div class="container-xl">

            <a class="navbar-brand" href="index.html">
                <img src="pictures/Logo/DJR_Aufkleber_weiß_oS_oH.png" id="navbar_logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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


    <!--Footer-->
    <footer id="footer">
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
            <a href="datenschutz.html" class="footer_link">Datenschutz</a> | <a href="impressum.html"
              class="footer_link">Impressum</a>
          </div>

        </div>

      </div>

    </footer>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous"></script>

</body>
</html>