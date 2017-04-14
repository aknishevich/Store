<?php
class Blog extends FrontController{
    public function Index()
    {
       $this->Render("blog");
    }
    public function ThemeId()
    {
        $this->model->AddComments();
        $this->Render("ThemeId");
    }
}