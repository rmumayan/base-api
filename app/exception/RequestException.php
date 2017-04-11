<?php
class RequestException extends Exception{
    
    public function __construct($userMessage,$code = 500, $link = "" ,Exception $previous = null) {
        $message = array(
                    'errors' => array(
                        'internalMessage'=>Helper::RequestStatus($code),
                        'code'=>$code,
                        'userMessage'=>$userMessage,
                        'moreInfo'=>$link));
        parent::__construct(json_encode($message), $code, $previous);
        
    }
}
