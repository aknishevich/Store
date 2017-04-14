<?php
class RunProject{
    public $url;
    public $object;
    public $action;
    public function __construct()
    {
        $this->object = "Product";
        $this->url = explode('/', $_SERVER['REQUEST_URI']);

        if ($this->url[1]=='') {header("location: /Product");}
        else {$this->object = $this->url[1];}
        if (!isset($this->url[2])) {$this->action = "Index"; }
        else {$this->action = $this->url[2];}

        if(strcmp($this->url[1], "Admin") == 0){        }
        if(isset($this->url[2])&&$this->url[2]==''){header("location: /{$this->url[1]}");}

        if(!method_exists($this->object, $this->action)){
            header("location: /Errors");
        }
    }
}