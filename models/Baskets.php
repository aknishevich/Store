<?php
class Baskets
{
    
    public function Check()
    {
        if(isset($_POST['decr']))
        {
            $pdo = Connect::getConnect();
            $Id = $_POST['IdBask'];
            $kodU = $_POST['kodU'];
            $obj = $pdo->prepare("select * from Baskets where Id = '{$Id}'");
            $obj->execute();
            $item = $obj->fetch();
            $count = 0;
            if($item['Count']!=1)
            {
                $count = $item['Count']-1;
                $pdo->query("update Baskets SET Count = '{$count}' where Id = '{$Id}'");
            }
            else
            {
                $pdo->query("delete from Baskets where Id = '{$Id}'");
            }
        }
	if(isset($_POST['decr1']))
        {
            $pdo = Connect::getConnect();
            $Id = $_POST['IdBask'];
            $kodU = $_POST['kodU'];
            $obj = $pdo->prepare("select * from Baskets where Id = '{$Id}'");
            $obj->execute();
            $item = $obj->fetch();
            $count = 0;
            if($item['Count']>10)
            {
                $count = $item['Count']-10;
                $pdo->query("update Baskets SET Count = '{$count}' where Id = '{$Id}'");
            }
            else
            {
                $pdo->query("delete from Baskets where Id = '{$Id}'");
            }
        }
	if(isset($_POST['decr2']))
        {
            $pdo = Connect::getConnect();
            $Id = $_POST['IdBask'];
            $kodU = $_POST['kodU'];
            $obj = $pdo->prepare("select * from Baskets where Id = '{$Id}'");
            $obj->execute();
            $item = $obj->fetch();
            $count = 0;
            if($item['Count']>100)
            {
                $count = $item['Count']-100;
                $pdo->query("update Baskets SET Count = '{$count}' where Id = '{$Id}'");
            }
            else
            {
                $pdo->query("delete from Baskets where Id = '{$Id}'");
            }
        }
	if(isset($_POST['secr']))
        {
            $pdo = Connect::getConnect();
            $Id = $_POST['IdBask'];
            $kodU = $_POST['kodU'];
            $obj = $pdo->prepare("select * from Baskets where Id = '{$Id}'");
            $obj->execute();
            $item = $obj->fetch();
            $count = 0;
            $count = $item['Count']+1;
            $pdo->query("update Baskets SET Count = '{$count}' where Id = '{$Id}'");
        }
	if(isset($_POST['secr1']))
        {
            $pdo = Connect::getConnect();
            $Id = $_POST['IdBask'];
            $kodU = $_POST['kodU'];
            $obj = $pdo->prepare("select * from Baskets where Id = '{$Id}'");
            $obj->execute();
            $item = $obj->fetch();
            $count = 0;
            $count = $item['Count']+10;
            $pdo->query("update Baskets SET Count = '{$count}' where Id = '{$Id}'");
        }
	if(isset($_POST['secr2']))
        {
            $pdo = Connect::getConnect();
            $Id = $_POST['IdBask'];
            $kodU = $_POST['kodU'];
            $obj = $pdo->prepare("select * from Baskets where Id = '{$Id}'");
            $obj->execute();
            $item = $obj->fetch();
            $count = 0;
            $count = $item['Count']+100;
            $pdo->query("update Baskets SET Count = '{$count}' where Id = '{$Id}'");
        }
        if(isset($_POST['dell']))
        {
            $pdo = Connect::getConnect();
            $Id = $_POST['IdBask'];
            $pdo->query("delete from Baskets where Id = '{$Id}'");
        }
        if(isset($_POST['order']))
        {
	$pdo = Connect::getConnect();
		$kodU = $_POST['kodU'];
	//While($pdo->query("SELECT * FROM Baskets WHERE UserId = '{$kodU}'")
	//{  
           $pdo->query(""); 
            //mail to
           $query=$pdo->query("SELECT * FROM Baskets WHERE Kod_User = '{$kodU}'");
           $members=$query->rowCount();
           $a = 0;
           while($members >= $a)
            {
            $pdo->query("INSERT INTO `Orders`(`UserId`, `ProductId`, `Count`, `Date`) VALUES ('{$kodU}',(SELECT Baskets.Kod_Product FROM Baskets WHERE Baskets.Kod_User = '{$kodU}' ORDER BY id DESC LIMIT 1),(SELECT Baskets.Count FROM Baskets WHERE Baskets.Kod_User = '{$kodU}' ORDER BY id DESC LIMIT 1),NOW())");
            $pdo->query("DELETE FROM `Baskets` WHERE Kod_User = '{$kodU}' AND Kod_Product = (SELECT Orders.ProductId FROM Orders WHERE Orders.UserId = '{$kodU}' ORDER BY id DESC LIMIT 1)");
            $a += 1;
            }
            echo 'Ваш заказ принят!';
         }
    }
}