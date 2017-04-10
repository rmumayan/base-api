<?php


class Helper{
    public static function parseUrl(){
        if(!isset($_GET['url'])) throw new Exception("Cannot process empty request.");
        $url = rtrim($_GET['url'],'/');
        return $url = explode('/',filter_var($url,FILTER_SANITIZE_URL));
    }

    public static function RequestStatus($code){
        $status = array(
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}