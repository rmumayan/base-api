<?php
class Controller{
    public function __construct(){
    }

    public function model($model){
       return new $model; 
    }
}

