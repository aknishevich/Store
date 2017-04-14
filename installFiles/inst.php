<?php
$pdo->exec("CREATE DATABASE IF NOT EXISTS `$databaseName`;");
$query = file_get_contents(dirname(__DIR__)."/installFiles/raketka.sql");
$pdo->exec("USE $databaseName");
$pdo->exec($query);