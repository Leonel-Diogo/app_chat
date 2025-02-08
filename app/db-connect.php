<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "app_chat";

try {
    $conn = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Falha na conexão: " . $error->getMessage();
}