<?php
class MyOrders extends FrontController{
    public function __construct(){
        parent::__construct();
        if( !isset($_SESSION['login'])){ header("Location: /Account/Login"); }
    }
    public function Index(){
           $this->Render("MyOrders");
    }
}



