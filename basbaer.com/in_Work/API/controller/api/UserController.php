<?php
class UserController extends BaseController

{
    /**
     * "/user/addUser Endpoint - Adds a user to the database
     */
    public function addUserAction(){
        $strErrorDesc = '';
        $strErrorHeader = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $requestData = json_decode(file_get_contents('php://input'), true);
                $email = $requestData["signUpMail"];
                #$email = $_POST["signUpMail"];

                # valdiate email
                if (! filter_var($email, FILTER_VALIDATE_EMAIL)){
                    die("Email is required");
                }

                # check password length
                if (strlen($_POST["signUpPassword"]) < 8) {
                    die("Password must be at least 8 characters");
                }

                #check if password contains letter
                if(! preg_match("/[a-z]/i", $_POST["signUpPassword"])){
                    die("Password must contain at least one letter");
                }

                #check if password contains number 
                if(! preg_match("/[0-9]/", $_POST["signUpPassword"])){
                    die("Password must contain at least one number");
                }

                #check if passwords match
                if($_POST["signUpPassword"] != $_POST["signUpPasswordConfirmation"]){
                    die("Passwords do not match");
                }

                $password_hash = password_hash($_POST["signUpPassword"], PASSWORD_DEFAULT);

                // Create a UserModel instance and call a method to add the user to the database
                $userModel = new UserModel();
                $userModel->addUser($email, $password_hash);

                $responseData = json_encode(array('message' => 'User added successfully'));
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 201 Created')
                );
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if ($strErrorDesc) {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }


    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $strErrorHeader = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if ($strErrorDesc) {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
