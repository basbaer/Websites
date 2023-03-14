<?php
define("RECAPTCHA_V3_SECRET_KEY", '6LfIhssiAAAAAAkRcFPzQLE-DnqsZvNb4FbD5TNh');
  
if (isset($_POST['inputText']) && $_POST['inputText']) {
    $inputText = filter_var($_POST['inputText']);
} else {
    // set error message and redirect back to form...
    header('location: rechapta.php');
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
    echo "It worked!";
} else {
    // spam submission
    // show error message
    echo "You are a bot";
}