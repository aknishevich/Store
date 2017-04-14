<?php
class Errors  extends FrontController{
    public function __construct(){}
    public function Index(){
        $this->Render("404");
    }
}