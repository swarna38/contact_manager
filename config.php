<?php
$host = 'localhost';
$db = 'contact_manager';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "success";
} catch(PDOException $e){
    die("Database connection failed: " . $e->getMessage());
}
?>
