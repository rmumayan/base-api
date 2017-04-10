<?php
require_once 'app/init.php';
//ENABLING CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");
header("HTTP/1.1 200 OK");

try{
    $app = new App();
}catch(RequestException $e){
    header("HTTP/1.1 " . $e->getCode() . " " . Helper::RequestStatus($e->getCode()));
    //log $e->getMessage();
}catch(Exception $e){
    //low level exception. this exception cannot be viewed by the user and must be logged on the database
}

