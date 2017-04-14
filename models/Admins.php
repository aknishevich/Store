<?php
class Admins
{
    
    public function DellVariation()
    {
        if(isset($_POST['dells']))
        {
            $pdo = Connect::getConnect();
            $idForDell = $_POST['id'];
            
            $pdo->query("delete from PTypes where Id = '{$idForDell}'");
            
        }
    }
    
    public function AddVariation()
    {
        if(isset($_POST['adds']))
        {
            $name = $_POST['Names'];
            $kod_T = $_POST['kodT'];
            
            $pdo = Connect::getConnect();
            $pdo->query("insert into PTypes(Kod_T, Name_PT) values ('{$kod_T}', '{$name}')");
        }
    }
    public function DellProduct()
    {
        if(isset($_POST['dells']))
        {
            $pdo = Connect::getConnect();
            $idForDell = $_POST['id'];
            $imgName = "images/".$_POST['imgName'];
            
            $pdo->query("delete from Products where Id = '{$idForDell}'");
            
            unlink($imgName);
        }
    }
    public function AddProduct()
    {
        if(isset($_POST['adds']))
        {
            $pdo = Connect::getConnect();
            
            $name = $_POST['Names'];
            $prc = $_POST['prc'];
            $ds = $_POST['ds'];
            $kodPT = $_POST['kod_pt'];
            
            $obj = $pdo->prepare("select * from PTypes where Id = '{$kodPT}'");
            $obj->execute();
            $el = $obj->fetch();
            $Kod_T = $el['Kod_T'];
            
            if($_FILES['icons']["size"] > 1024*3*1024)
                {
                    echo ("<p>Розмір файлу перевищує три мегабайти</p>");
                    exit;
                }
                if(is_uploaded_file($_FILES['icons']["tmp_name"]))
                {
                    include"config.php";
                    include"models/ConnectDB.php";
                    $img = $_FILES['icons']['name'];
                    move_uploaded_file($_FILES['icons']["tmp_name"], "images/".$_FILES['icons']["name"]);
                    $query = "INSERT INTO Products(Name, Kod_T, Price, images, DS, Kod_PT) VALUES('{$name}', '{$Kod_T}', '{$prc}', '{$img}', '{$ds}', '{$kodPT}')";
                    $list = $pdo->query($query);
                } else {
                    echo("Помилка при завантаженні файлу");
                }
        }
    }
    public function AddType()
    {
        if(isset($_POST['adds']))
        {
            $pdo = Connect::getConnect();
            $nameType = $_POST['NameType'];
            $pdo->prepare("INSERT INTO Types(Name) VALUES('{$nameType}')");
        }
    }
    public function DellType()
    {
        if(isset($_POST['dells']))
        {
            $pdo = Connect::getConnect();
            $idForDell = $_POST['id'];
            $imgName = "images/".$_POST['imgName'];
            
            $pdo->query("delete from Types where Id = '{$idForDell}'");
            
            unlink($imgName);
        }
    }
    public function AddTheme()
    {
        if(isset($_POST['adds'])) 
        {
            $pdo = Connect::getConnect();
            
            $name = $_POST['names'];
            $desk = $_POST['dess'];
            
            $pdo->prepare("insert into Blog(Name, Descriptions) values('{$name}', '{$desk}')");
        }
    }
    public function DellTheme()
    {
        if(isset($_POST['dells'])) 
        {
            $pdo = Connect::getConnect();
            $id = $_POST['Id'];
            $pdo->query("delete from Blog where Id = '{$id}'");
        }
    }
    public function DellComment()
    {
        if(isset($_POST['dells'])) 
        {
            $pdo = Connect::getConnect();
            $id = $_POST['Id'];
            $pdo->query("delete from Comments where Id = '{$id}'");
        }
    }
    public function CheckUsers(){
        $isUser = false;
        $isAdmin = false;
        $pdo = Connect::getConnect();
        if(isset($_SESSION['login'])){
            if(isset($_COOKIE["{$_SESSION['login']}"])) {
                $nameUser = $_SESSION['login'];
                $query = "SELECT * FROM Users WHERE Names = '{$nameUser}'";
                $listUser = $pdo->query($query);
                $arrUser = $listUser->fetch();
                $thisUser = $_SESSION['login'];
                $thisPass = $_SESSION['pass'];


                    if (isset($_COOKIE[$thisUser]) && strcmp($_COOKIE[$thisUser], $thisPass) == 0) {
                        $isUser = true;
                    }
                    if (isset($_COOKIE[$thisUser]) && strcmp($_COOKIE[$thisUser], $thisPass)==0 && $arrUser['Kod_roles']==1) {
                        $isAdmin = true;
                    }
                
            }
        }
        if($isAdmin) return 2;
        if($isUser) return 1;
        else return 0;
    }
}