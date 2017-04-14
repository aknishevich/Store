<?php
class Product extends FrontController
{
    public function Index()
    {
        $this->Render("Product");
    }
    public function CategoryId()
    {
        $this->Render("CategoryId");
    }
    public function Type()
    {
        $this->Render("Type");
    }
    public function ElementId()
    {
        $this->model->AddProductBasket();
        $this->Render("ElementId");
    }
}