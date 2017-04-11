<?php
class Controller{
    public function __construct(){
    }

    public function model($model){  
       $m_name = $model.'Model';
       return new $m_name; 
    }
}

