<?php
$servername = "localhost";  
$username   = "root";     
$password   = "";            
$dbname     = "planesnegocio"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
header('Content-Type: text/html; charset=utf-8');