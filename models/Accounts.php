<?php
class Accounts{
    public function ChangeMail()
    {
        if(isset($_POST['change'])&& isset($_SESSION['login']))
        {
            $alt_pass = $_POST['alt_pass'];
            $newPass1 = $_POST['new_pass'];
            $newPass2 = $_POST['new_pass2'];
            
            $pdo = Connect::getConnect();
            $obj = $pdo->prepare("select * from Users where Names = '{$_SESSION['login']}' and Mail = '{$alt_pass}'");
            $obj->execute();
            $user = $obj->fetch();
            if(strcmp($newPass1,$newPass2)==0)
            {
                $pdo->query("update Users set Mail='{$newPass1}' where ID = '{$user['ID']}'");
                return 1;
            }  
             return 0;
        }
        return 2;
    }
    public function ChangePass()
    {
        if(isset($_POST['change'])&& isset($_SESSION['login']))
        {
            $alt_pass = md5($_POST['alt_pass']);
            $newPass1 = md5($_POST['new_pass']);
            $newPass2 = md5($_POST['new_pass2']);
            
            $pdo = Connect::getConnect();
            $obj = $pdo->prepare("select * from Users where Names = '{$_SESSION['login']}' and Password = '{$alt_pass}'");
            $obj->execute();
            $user = $obj->fetch();
            if(strcmp($newPass1,$newPass2)==0)
            {
                $pdo->query("update Users set Password='{$newPass1}' where ID = '{$user['ID']}'");
                return 1;
            }  
             return 0;
        }
        return 2;
    }
    public function Valid(){
        if(isset($_POST['logs'])){
            $pdo = Connect::getConnect();
            $userPass = md5($_POST['pass']);
            $nameUser = $_POST['login'];
            $query = ("SELECT * FROM Users WHERE Names = '{$nameUser}'");

            $us = $pdo->query($query);
            $IsUser =$us->fetch();

            if(strcmp($IsUser['Password'],$userPass)==0){
                setcookie($nameUser,$userPass, time()+992600, '/');
                $_SESSION['login'] = $nameUser;
                $_SESSION['pass'] = $userPass;
                header("Location: /Account");
            }   
        }
    }
    public function LogOut(){
        if(!isset($_SESSION['login'])){ header("Location: /Product"); }
        setcookie($_SESSION['login'],"");
        unset($_SESSION['login']);
        unset($_SESSION['pass']);
        session_destroy();
        header("Location: /Account"); 
    }
    public function Capcha(){
        $a = array();
        for($i=0; $i<5; $i++){
            array_push($a, rand(1,9));
        }
        $maximum =  max($a);
        $str = '';
        for($i=0; $i<5; $i++){
            $str=$str.$a[$i];
        }
        $obj = array($maximum, $str);
        return $obj;
    }
    public function RegistrationInDB(){
        if(isset($_POST['registration'])) {
            $capcha = $_POST['capcha'];
            if($capcha == $_SESSION['obj'][0]){
                $pdo = Connect::getConnect();
                $login = $_POST['log'];
                $passUser = md5($_POST['pass']);
		$cityUser = $_POST['city'];
                $mail = $_POST['mail'];

                $isValid = false;
                $input = true;
                $query = "SELECT * FROM Users WHERE Names = '{$login}'";
                $list = $pdo->query($query);
                $doubleUser = $list->fetchAll();

                if (count($doubleUser) == 0) {
                    $isValid = true;
                }
                if ($isValid) {
                    $newUser = ("INSERT INTO Users(Names, Password, City, Mail, Kod_roles) VALUES('{$login}', '{$passUser}', '{$cityUser}', '{$mail}', '2')");
                    $pdo->query($newUser);
                }
            }
            else{
                return array(-1);
            }
            header("Location: /Account/Login");
        }
        $a = array();
        for($i=0; $i<5; $i++){
            array_push($a, rand(0,9));
        }
        $min =  min($a);
        $str = '';
        for($i=0; $i<5; $i++){
            $str=$str.$a[$i];
        }
        $_SESSION['obj'] = array($min, $str);
        return $_SESSION['obj'];
    }
}