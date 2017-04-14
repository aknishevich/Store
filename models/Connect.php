<?php
class Connect
{
    public static  function getConnect()
    {
        include"config.php";
        $pdo = new PDO("mysql:host=" . $host, $user, $password) or Die("error connect with " . $host);
        $pdo->query("CREATE DATABASE IF NOT EXISTS " . $databaseName . ";");
        $tryConnect = $pdo->query("USE " . $databaseName);
        $list = ("SELECT * FROM  `products`");
        $tryProducts = $pdo->query($list);
        if (!$tryProducts) {
            require_once dirname(__DIR__) . '/installFiles/' . 'inst.php';
        }
        unset($tryProducts);
        return $pdo;
    }
}