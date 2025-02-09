<?php
$host = "localhost";
$dbname = "app_chat";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Falha na conexão: " . $error->getMessage();
}