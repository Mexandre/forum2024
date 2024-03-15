<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$host = "localhost";
$db = "forum";
$var = "charset=utf8";
$user = "root";
$pass = "root";
try {
    $cnx = new PDO("mysql:host=$host;dbname=$db;$var", $user, $pass);
}
catch (PDOException $e){
    die("Connexion impossible". $e->getMessage());
}
?>