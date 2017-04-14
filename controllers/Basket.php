<?php
class Basket extends FrontController
{
    public function __construct(){
        parent::__construct();
        if( !isset($_SESSION['login'])){ header("Location: /Account/Login()"); }
    }
    public function Index()
    {
        $this->model->Check();
        $this->Render("Basket");
    }
}