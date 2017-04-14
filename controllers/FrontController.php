<?php
class FrontController{
    private $view;
    private $url;
    public $model;
    public $className;
    public function __construct()
    {
        $this->IncFiles();
    }
    public function Render($string, $values=""){
        $this->view = new Render($string, $values);
    }
    public function IncFiles(){
        $this->url = explode('/', $_SERVER['REQUEST_URI']);
        if($this->url[1]!=''){
            if(file_exists("models/".$this->url[1]."s.php")) {
                include "models/" . $this->url[1] . "s.php";
                $this->className = $this->url[1]."s";
                $this->model = new $this->className();
            }
        }
    }
}