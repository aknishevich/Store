<?php
class Products
{
    public function AddProductBasket()
    {
        if(isset($_SESSION['login']))
        {
            if(isset($_POST['adds']))
            {
                $pdo = Connect::getConnect();

                $id_P = $_POST['Id'];
                $nm = $_SESSION['login'];



                $obj = $pdo->prepare("select * from Users where Names = '{$nm}'");
                $obj->execute();
                $User = $obj->fetch();
                $userId = $User['ID'];


                $IsValid = $pdo->prepare("select * from Baskets where Kod_User = '{$userId}' and Kod_Product = '{$id_P}'");
                $IsValid->execute();
                $IsAdded = $IsValid->fetch();
                if(!empty($IsAdded))
                {
                    $count = $IsAdded['Count']+1;
                    $id = $IsAdded['Id'];
                    $pdo->query("update Baskets set Count = '{$count}' where Id = '{$id}'");
                }
            
                else
                {
                    $pdo->query("insert into Baskets(Kod_User, Kod_Product, Count) values('{$userId}', '{$id_P}', 1)");
                }
                header("Location: /Product/ElementId/".$id_P);
            }
            
        }
        else
        {
            header("Location: /Account");
        }
    }
}