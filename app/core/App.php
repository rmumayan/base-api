<?php
class App{
    protected $url;
    protected $controller;
    protected $method;
    protected $params = [];
    
    public function __construct($request,$origin){
        $this->url = Helper::parseUrl($request);
        $this->ToSingularNoun();
        $this->Set_controller_and_require();
        $this->_set_params();
        $this->_set_method();
        $this->_verify_API();
        call_user_func([$this->controller,$this->method],$this->params);
    }

    private function  Set_controller_and_require(){
        $c_name =  ucfirst($this->url[0]).'Controller';

        $this->controller = new $c_name;
        unset($this->url[0]); //to make sure that this value wont be add on Set_params method
    }


    private function _set_method(){
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    private function _set_params(){
        $this->params = $this->url ? array_values($this->url) : [];
    }

    private function _verify_API(){
         if (!method_exists($this->controller, $this->method)) throw new RequestException("Method '".$this->method."' does not exist.",404);
    }



    private function ToSingularNoun(){
        $last_position_of_s = strrpos($this->url[0],"s");
        $this->url[0] = substr_replace($this->url[0],'',$last_position_of_s,1);
    }
}