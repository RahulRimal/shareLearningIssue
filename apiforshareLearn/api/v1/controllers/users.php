<?php

require('../../../core/init.php');
require_once('../libraries/Session.php');
require_once('../libraries/User.php');
require_once('../libraries/Response.php');

?>

<?php

if (!isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1) {
    $response = new Response();
    $response->setHttpStatusCode(401);
    $response->setSuccess(false);
    (!isset($_SERVER['HTTP_AUTHORIZATION']) ? $response->addMessage("Access token missing from the header") : false);
    isset($_SERVER['HTTP_AUTHORIZATION']) ? ((strlen($_SERVER['HTTP_AUTHORIZATION']) < 1 ? $response->addMessage("Access token cannot be blank") : false)) : false;
    $response->send();
    exit;
}

$accessToken = $_SERVER['HTTP_AUTHORIZATION'];

// Getting Existing User
// /users/1

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['user'])) {
        $uId = $_GET['user'];
        $user = new User('tempUser', 'tempPass', null, 'tempFirst', 'tempLast', null, null, null);
        $response = $user->getDetails($uId);

        $response->send();
        exit;
    } elseif(isset($_SERVER['HTTP_AUTHORIZATION']))
    {
        $sess = new Session();

        $sess->getSessionInfo($accessToken);

        $user = new User('tempUser', 'tempPass', null, 'tempFirst', 'tempLast', null, null, null);
        $response = $user->getDetails($sess->getUserId());
        $response->send();
        exit;
    }
    else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("User id not set");
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SERVER['CONTENT_TYPE'])) {
        if ($_SERVER['CONTENT_TYPE'] != 'application/json') {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("Header type not set to JSON");
            $response->send();
            exit;
        }
    }

    if (!isset($_SERVER['CONTENT_TYPE'])) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Header type not set to JSON");
        $response->send();
        exit;
    }


    $rawData = file_get_contents('php://input');

    if (!$jsonData = json_decode($rawData)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Invalid JSON body");
        $response->send();
        exit;
    }

    if (!isset($jsonData->username) || !isset($jsonData->password) || !isset($jsonData->firstName) || !isset($jsonData->lastName)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->username) ? $response->addMessage("Username is required") : false;
        !isset($jsonData->password) ? $response->addMessage("Password is required") : false;
        !isset($jsonData->firstName) ? $response->addMessage("First name is required") : false;
        !isset($jsonData->lastName) ? $response->addMessage("Last name is required") : false;
        $response->send();
        exit;
    }

    try {
        $newUser = new User($jsonData->username, $jsonData->password, isset($jsonData->email) ? $jsonData->email : null, $jsonData->firstName, $jsonData->lastName, isset($jsonData->class) ? $jsonData->class : null, isset($jsonData->description) ? $jsonData->description : null, isset($jsonData->followers) ? $jsonData->followers : null);

        $response = $newUser->createNewUser();
        $response->send();
        exit;
    } catch (UserException $ex) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage($ex->getMessage());
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    if (isset($_SERVER['CONTENT_TYPE'])) {
        if ($_SERVER['CONTENT_TYPE'] != 'application/json') {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("Header type not set to JSON");
            $response->send();
            exit;
        }
    }

    if (!isset($_SERVER['CONTENT_TYPE'])) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Header type not set to JSON");
        $response->send();
        exit;
    }

    $rawData = file_get_contents('php://input');

    if (!$jsonData = json_decode($rawData)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Invalid JSON body");
        $response->send();
        exit;
    }

    if (isset($_GET['user'])) {
        $uId = $_GET['user'];

        $user = new User('tempUser', 'tempPass', null, 'tempFirst', 'tempLast', null, null, null);

        if (!isset($jsonData->password) && !isset($jsonData->email) && !isset($jsonData->firstName) && !isset($jsonData->lastName) && !isset($jsonData->class) && !isset($jsonData->description)) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("No information to update");
            $response->send();
            exit;
        }

        if (isset($jsonData->password) || isset($jsonData->email) || isset($jsonData->firstName) || isset($jsonData->lastName) || isset($jsonData->class) || isset($jsonData->description)) {
            $receivedData = array();

            isset($jsonData->password) ? $receivedData['password'] = $jsonData->password : false;
            isset($jsonData->email) ? $receivedData['email'] = $jsonData->email : false;
            isset($jsonData->firstName) ? $receivedData['firstName'] = $jsonData->firstName : false;
            isset($jsonData->lastName) ? $receivedData['lastName'] = $jsonData->lastName : false;
            isset($jsonData->class) ? $receivedData['class'] = $jsonData->class : false;
            isset($jsonData->description) ? $receivedData['description'] = $jsonData->description : false;
            $response = $user->updateInfo($uId, $receivedData);
            $response->send();
            exit;
        } else {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            isset($jsonData->username) ? $response->addMessage('Username can\'t be updated') : false;
            isset($jsonData->id) ? $response->addMessage('User ID can\'t be updated') : false;
            isset($jsonData->followers) ? $response->addMessage('Followers can\'t be updated manually') : false;
            isset($jsonData->userCreatedDate) ? $response->addMessage('User Signed up date can\'t be updated') : false;
            $response->send();
            exit;
        }
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("User is required to update information");
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['user'])) {
        $uId = $_GET['user'];

        $user = new User('tempUser', 'tempPass', null, 'tempFirst', 'tempLast', null, null, null);
        $response = $user->deleteUser($uId);
        $response->send();
        exit;
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("User is required for deletion");
        $response->send();
        exit;
    }
} else {
    $response = new Response();
    $response->setHttpStatusCode(405);
    $response->setSuccess(false);
    $response->addMessage("Requested method not allowed");
    $response->send();
    exit;
}




?>