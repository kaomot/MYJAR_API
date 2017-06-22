<?php
/**
 * Author: Kayode Omotoye
 */
require_once('RequestHandler.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$requestHandler = new RequestHandler();

//recieve client data
if ($requestMethod == 'POST') {
    $requestData = file_get_contents('php://input');
    $response = $requestHandler->handlePostRequest($requestData);
    echo $response;
    return;
}

//GET client data
else if ($requestMethod == 'GET') {
    $response = $requestHandler->handleGetRequest($_GET);
    echo $response;
    return;
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not supported']);
}
?>