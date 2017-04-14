<?php
    class Blogs
    {
        public function AddComments()
        {
            if(isset($_POST['adds']))
            {
                if(isset($_SESSION['login']))
                {
                    $pdo = Connect::getConnect();
                    
                    $idTheme = $_POST['id'];
                    $comm = $_POST['newComment'];
                    $nm = $_SESSION['login'];
                    
                    $obj = $pdo->prepare("select * from Users where Names = '{$nm}'");
                    $obj->execute();
                    $User = $obj->fetch();
                    $userId = $User['ID'];
                    
                    $date = date("Y-m-d");
                    
                    $pdo->query("insert into Comments(Kod_User, Kod_Blog, date, comments) values ('{$userId}', '{$idTheme}', '{$date}','{$comm}')");
                    header("Location: /Blog/ThemeId/".$idTheme);
                    
                }
                else
                {
                    header("Location: /Account/Login");
                }
            }
        }
    }
