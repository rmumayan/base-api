<?php
require_once 'app/init.php';
//ENABLING CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");
header("HTTP/1.1 200 OK");
try{
    //SAME SERVER REQUEST DOESNT NEED A HTTP_ORIGIN
    if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
    $app = new App($_REQUEST['url'],$_SERVER['HTTP_ORIGIN']);
}catch(RequestException $e){
    header("HTTP/1.1 " . $e->getCode() . " " . Helper::RequestStatus($e->getCode()));
    echo $e->getMessage();
    //log $e->getMessage();
}catch(Exception $e){
    //low level exception. this exception cannot be viewed by the user and must be logged on the database
}

