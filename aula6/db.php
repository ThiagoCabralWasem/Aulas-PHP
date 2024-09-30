<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bloco-de-notas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . htmlspecialchars($conn->connect_error));
}

$conn->set_charset("utf8mb4");
?>