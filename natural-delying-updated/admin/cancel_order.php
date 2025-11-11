<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['es_admin'] != 1) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE pedidos SET estado = 'Cancelado' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al cancelar el pedido: " . $conn->error;
    }
}
?>
