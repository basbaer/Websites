<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

# parses the url into its components
$uri = explode( '/', $uri );

# currently only the user endpoint exists, therefore it is checked
# if user is called and if the second component is there
if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/controller/api/UserController.php";
$objFeedController = new UserController();
#converts the uri component to a method name by adding action
#e.g. list -> listAction
$strMethodName = $uri[3] . 'Action';
$objFeedController->{$strMethodName}();
