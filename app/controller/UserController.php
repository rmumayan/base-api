<?php

class UserController extends Controller{
    public function GET($arg = []){
        $model = $this->model('User');
        echo json_encode($model->query());
        // echo 'yeah';
        // echo $_GET['username'];
    }
}
