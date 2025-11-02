<?php
$servername = "sql213.infinityfree.com";  
$username   = "if0_40153646";     
$password   = "5eq8hJEGdd";            
$dbname     = "if0_40153646_planes_negocio"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
header('Content-Type: text/html; charset=utf-8');