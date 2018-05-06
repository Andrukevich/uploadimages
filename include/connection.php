<?php

//Соединение с БД
include_once("data.php");

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$pdo = new PDO($dsn, $user, $pass, $opt);