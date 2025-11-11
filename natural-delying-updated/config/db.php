<?php
$servername = "localhost";
$username = "natural_delying_user";
$password = "password123";
$dbname = "natural_delying";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
