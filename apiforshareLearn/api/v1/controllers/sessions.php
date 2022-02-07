<?php

require('../../../core/init.php');
require_once('../libraries/Session.php');
require_once('../libraries/Response.php');
require_once('../helpers/session_helper.php');

?>



<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $accessToken = getBearerToken();

    $sess = new Session();

    $sess = $sess->getSessionInfo($accessToken);

    $returnData = array();
    $returnData['rows_returned'] = 1;
    $returnData['session'] = $sess->returnSessionAsArray();

    $response = new Response();
    $response->setHttpStatusCode(200);
    $response->setSuccess(true);
    $response->addMessage('Session retrievd successfully');
    $response->setData($returnData);
    $response->send();

    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    sleep(1);

    if (isset($_SERVER['CONTENT_TYPE']) &&
    (
        ($_SERVER['CONTENT_TYPE'] != 'application/json')
    // ||
    // ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
    )) {
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

    // if (!isset($jsonData->userId)) {
    //     $response = new Response();
    //     $response->setHttpStatusCode(400);
    //     $response->setSuccess(false);
    //     $response->addMessage("User ID required to create a session");
    //     $response->send();
    //     exit;
    // }

    if (!isset($jsonData->username) && !isset($jsonData->email)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Username or email required to create a session");
        $response->send();
        exit;
    }

    $username = isset($jsonData->username) ? $jsonData->username : null;
    $email = isset($jsonData->email) ? $jsonData->email : null;

    if (!isset($jsonData->password)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Password required");
        $response->send();
        exit;
    }

    $password = $jsonData->password;

    $session = new Session();

    $response = $session->loginUser($email, $username, $password);
    $response->send();
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    if (!isset($_GET['session'])) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Session ID required to update session");
        $response->send();
        exit;
    }
    if ($_SERVER['CONTENT_TYPE'] != 'application/json') {
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

    if (!isset($jsonData->refreshToken) || strlen($jsonData->refreshToken) < 1) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        (!isset($jsonData->refresh_token) ? $response->addMessage("Refresh Token not supplied") : false);
        (strlen($jsonData->refresh_token) < 1 ? $response->addMessage("Refresh Token cannot be blank") : false);
        $response->send();
        exit;
    }

    $session = new Session();
    $response =  $session->updateSession($jsonData->refreshToken);
    $response->send();
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (!isset($_GET['session'])) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Session ID required to delete a session");
        $response->send();
        exit;
    }

    $sessId = $_GET['session'];

    $session = new Session();

    $response =  $session->deleteSession($sessId);
    $response->send();
    exit;
} else {
    $response = new Response();
    $response->setHttpStatusCode(405);
    $response->setSuccess(false);
    $response->addMessage("Requested method not allowed");
    $response->send();
    exit;
}


?>