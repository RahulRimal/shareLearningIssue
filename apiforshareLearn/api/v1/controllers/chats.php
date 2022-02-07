<?php

require('../../../core/init.php');
require_once('../libraries/Chat.php');
require_once('../libraries/Response.php');
require_once('../libraries/Session.php');


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

$sess = new Session();

$sessionInfo = $sess->getSessionInfo($accessToken);

$uId = $sessionInfo->getUserId();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['nextUser']) && isset($_GET['single'])) {

        $nextUId = $_GET['nextUser'];

        $chat = new Chat();

        $response = $chat->getSingleMessage($uId, $nextUId);
        $response->send();
    } elseif (isset($_GET['nextUser']) && isset($_GET['double'])) {

        $nextUId = $_GET['nextUser'];

        $chat = new Chat();

        $response = $chat->getAMessage($uId, $nextUId);
        $response->send();
    } elseif (isset($_GET['nextUser'])) {

        $nextUId = $_GET['nextUser'];

        $chat = new Chat();

        $response = $chat->getAllMessages($uId, $nextUId);
        $response->send();
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Two users required to get messages");
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

    $sess = new Session();

    $sess = $sess->getSessionInfo($accessToken);

    $uId = $sess->getUserId();

    // if (!isset($jsonData->outgoingId) || !isset($jsonData->incomingId) || !isset($jsonData->message) || !isset($jsonData->messageSentDate)) {
    if (!isset($jsonData->outgoingId) || !isset($jsonData->incomingId) || !isset($jsonData->message)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->outgoingId) ? $response->addMessage("Outgoing id is required to post a message") : false;
        !isset($jsonData->incomingId) ? $response->addMessage("Incoming id is required to post a message") : false;
        !isset($jsonData->message) ? $response->addMessage("Message body is required to post a message") : false;
        !isset($jsonData->messageSentDate) ? $response->addMessage("Message sent date is required to post a message") : false;
        $response->send();
        exit;
    }

    $data = array();

    if (isset($jsonData->outgoingId))
        $data['outgoingId'] = $jsonData->outgoingId;

    if (isset($jsonData->incomingId))
        $data['incomingId'] = $jsonData->incomingId;

    if (isset($jsonData->message))
        $data['message'] = $jsonData->message;

    // if (isset($jsonData->messageSentDate))
    //     $data['messageSentDate'] = $jsonData->messageSentDate;


    $chat = new Chat();
    $response = $chat->createMessage($data['outgoingId'], $data['incomingId'], $data);
    $response->send();
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $sess = new Session();

    $sess = $sess->getSessionInfo($accessToken);

    $uId = $sess->getUserId();

    if (isset($_GET['chat'])) {

        $id = $_GET['chat'];

        $chat = new Chat();
        $response = $chat->deleteMessage($id);

        $response->send();
        exit;
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Chat ID required to delete the chat");
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

    $sess = new Session();

    $sess = $sess->getSessionInfo($accessToken);

    $uId = $sess->getUserId();

    if (isset($_GET['chat'])) {

        $id = $_GET['chat'];

        $data = array();
        $data['id'] = $id;

        if (isset($jsonData->id) || isset($jsonData->outgoingId) || isset($jsonData->incomingId) || isset($jsonData->message) || isset($jsonData->messageSentDate)) {
            isset($jsonData->id) ? $data['id'] = $jsonData->id : false;
            isset($jsonData->outgoingId) ? $data['outgoingId'] = $jsonData->outgoingId : false;
            isset($jsonData->incomingId) ? $data['incomingId'] = $jsonData->incomingId : false;
            isset($jsonData->message) ? $data['message'] = $jsonData->message : false;
            isset($jsonData->messageSentDate) ? $data['messageSentDate'] = $jsonData->messageSentDate : false;

            $chat = new Chat();
            $response = $chat->updateMessage($id, $data);
            $response->send();
            exit;
        } else {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("Nothing changed to update");
            $response->send();
            exit;
        }
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Message id required to update the chat");
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $sess = new Session();

    $sess = $sess->getSessionInfo($accessToken);

    $uId = $sess->getUserId();

    if (isset($_GET['chat'])) {

        $id = $_GET['chat'];

        $chat = new Chat();
        $response = $chat->deleteMessage($id);

        $response->send();
        exit;
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Message ID required to delete the message");
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