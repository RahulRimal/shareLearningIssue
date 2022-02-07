<?php

function getBearerToken()
{
    if (!isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1) {
        $response = new Response();
        $response->setHttpStatusCode(401);
        $response->setSuccess(false);
        (!isset($_SERVER['HTTP_AUTHORIZATION']) ? $response->addMessage("Access token missing from the header") : false);
        isset($_SERVER['HTTP_AUTHORIZATION']) ? ((strlen($_SERVER['HTTP_AUTHORIZATION']) < 1 ? $response->addMessage("Access token cannot be blank") : false)) : false;
        $response->send();
        exit;
    }
    
    // $accessToken = $_SERVER['HTTP_AUTHORIZATION'];
    return $_SERVER['HTTP_AUTHORIZATION'];
}


?>