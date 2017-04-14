<?php
class Admin extends FrontController{
    public function __construct(){
        parent::__construct();
        if( $this->model->CheckUsers()!=2){header("Location: /Errors"); }
    }
    public function Index(){
           $this->Render("Admin/Admin");
    }
    public function AddTheme()
    {
        $this->model->AddTheme();
        $this->Render("Admin/AddTheme");
    }
    public function DellTheme()
    {
        $this->model->DellTheme();
        $this->Render("Admin/DellTheme");
    }
    public function DellComment()
    {
        $this->model->DellComment();
        $this->Render("Admin/DellComment");
    }
    public function AddType()
    {
        $this->model->AddType();
        $this->Render("Admin/AddType");
    }
    public function DellType()
    {
        $this->model->DellType();
        $this->Render("Admin/DellType");
    }
    public function AddProduct()
    {
        $this->model->AddProduct();
        $this->Render("Admin/AddProduct");
    }
    public function DellProduct()
    {
        $this->model->DellProduct();
        $this->Render("Admin/DellProduct");
    }
    public function AddVariation()
    {
        $this->model->AddVariation();
        $this->Render("Admin/AddVariation");
    }
    public function DellVariation()
    {
        $this->model->DellVariation();
        $this->Render("Admin/DellVariation");
    }
    public function Search()
    {
        $this->model->DellVariation();
        $this->Render("Admin/Search");
    }
}



