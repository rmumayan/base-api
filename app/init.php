<?php
session_start();
date_default_timezone_set("Asia/Manila");
require_once 'paths.php';
require_once 'core/App.php';
require_once 'core/Authentication.php';
require_once 'core/Controller.php';
require_once 'core/Helper.php';




spl_autoload_register(function($class){ 
    //loading exceptions
    if (strpos($class,'Exception') !== false ) require_once EX_PATH.DS.$class.'.php';

    //loading controllers
    if (strpos($class,'Controller') !== false && $class != 'Controller') {
        if(!file_exists(C_PATH.DS.$class.'.php')) throw new RequestException("Controller '".$class."' does not exist.",404);
        require_once C_PATH.DS.$class.'.php';
    }
    
    //loading models
    if (strpos($class,'Model') !== false ) {
        if(!file_exists(M_PATH.DS.$class.'.php')) throw new RequestException("Model '".$class."' does not exist.",404);
        require_once M_PATH.DS.$class.'.php';
    }
});
