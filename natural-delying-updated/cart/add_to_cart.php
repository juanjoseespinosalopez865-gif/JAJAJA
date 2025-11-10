<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    $usuario_id = $_SESSION['usuario_id'];
    $cantidad = 1; // Por simplicidad, añadimos uno cada vez

    $sql = "INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES ('$usuario_id', '$producto_id', '$cantidad')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_cart.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
