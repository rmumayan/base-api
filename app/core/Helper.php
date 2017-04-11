<?php


class Helper{
    public static function parseUrl($request){
        if(!$request) throw new RequestException("Cannot process empty request.",404);
        $url = rtrim($request,'/');
        return $url = explode('/',filter_var($url,FILTER_SANITIZE_URL));
    }



    public static function RequestStatus($code){
        $status = array(
            200 => 'OK',
            201 => 'New resource has been created',
            204 => 'The resource was successfully deleted',
            400 => 'Bad Request', //The exact error should be explained in the error payload. E.g. „The JSON is not valid“
            304 => 'Not Modified',
            401 => 'Unauthorized', //The request requires an user authentication
            403 => 'Forbidden', //The server understood the request, but is refusing it or the access is not allowed.
            404 => 'Not Found', //There is no resource behind the URI.
            500 => 'Internal Server Error'
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}