<?php

require('../../../core/init.php');
require_once('../libraries/Reply.php');
require_once('../libraries/Response.php');

?>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['post'])) {
        $pId = $_GET['post'];
        $reply = new Reply();
        $response = $reply->getPostReplies($pId);
        $response->send();
        exit;
    } elseif (isset($_GET['reply'])) {
        $rId =  $_GET['reply'];
        $reply = new Reply();
        $response = $reply->getDetails($rId);
        $response->send();
        exit;
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Post or Reply id required");
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

    if (!isset($jsonData->userId) || !isset($jsonData->postId) || !isset($jsonData->body)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->userId) ? $response->addMessage("User Id is required to post a reply") : false;
        !isset($jsonData->postId) ? $response->addMessage("Post Id is required to post a reply") : false;
        !isset($jsonData->body) ? $response->addMessage("Reply body is required to post a reply") : false;
        $response->send();
        exit;
    }

    $data = array();

    if (isset($jsonData->userId))
        $data['userId'] = $jsonData->userId;

    if (isset($jsonData->postId))
        $data['postId'] = $jsonData->postId;

    if (isset($jsonData->body))
        $data['body'] = $jsonData->body;

    $reply = new Reply();
    $response = $reply->createReply($data);
    $response->send();
    exit();
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
    if (isset($_GET['reply'])) {

        $id = $_GET['reply'];

        $data = array();


        if (isset($jsonData->userId) || isset($jsonData->postId) || isset($jsonData->body) || isset($jsonData->createdDate)) {
            isset($jsonData->userId) ? $data['userId'] = $jsonData->userId : false;
            isset($jsonData->postId) ? $data['postId'] = $jsonData->postId : false;
            isset($jsonData->body) ? $data['body'] = $jsonData->body : false;
            isset($jsonData->createdDate) ? $data['createdDate'] = $jsonData->createdDate : false;

            $reply = new Reply();
            $response = $reply->updateReply($id, $data);
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
        $response->addMessage("Reply ID required to update the reply");
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    if (isset($_GET['reply'])) {

        $id = $_GET['reply'];

        $reply = new Reply();
        $response = $reply->deleteReply($id);
        $response->send();
        exit;
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Reply ID required to delete the reply");
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