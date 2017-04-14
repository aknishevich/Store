<?php
class Account extends FrontController{
    public function Index(){
        if(isset($_SESSION['login']))
            $this->Render("PersonalAcount");
        else
            header("Location: /Account/Login");
    }
    public function Login(){
        $this->model->Valid();
        $this->Render("login");
    }
    public function Registration(){
        $val = $this->model->RegistrationInDB();
        $this->Render("Registations", $val);
    }
    public function LogOut(){
        $this->model->LogOut();
    }
    public function ChangePassword()
    {
        $result = $this->model->ChangePass();
        $this->Render("Login/ChangePassword", $result);
    }
    public function ChangeMail()
    {
        $result = $this->model->ChangeMail();
        $this->Render("Login/ChangeMail", $result);
    }
}