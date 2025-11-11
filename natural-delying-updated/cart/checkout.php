<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Iniciar transacción
$conn->begin_transaction();

try {
    // 1. Crear el pedido
    $sql_pedido = "INSERT INTO pedidos (usuario_id) VALUES ('$usuario_id')";
    $conn->query($sql_pedido);
    $pedido_id = $conn->insert_id;

    // 2. Mover productos del carrito a pedido_productos
    $sql_carrito = "SELECT p.id, p.precio, c.cantidad FROM carrito c JOIN productos p ON c.producto_id = p.id WHERE c.usuario_id = '$usuario_id'";
    $result_carrito = $conn->query($sql_carrito);

    while ($row = $result_carrito->fetch_assoc()) {
        $producto_id = $row['id'];
        $cantidad = $row['cantidad'];
        $precio = $row['precio'];
        $sql_pedido_producto = "INSERT INTO pedido_productos (pedido_id, producto_id, cantidad, precio) VALUES ('$pedido_id', '$producto_id', '$cantidad', '$precio')";
        $conn->query($sql_pedido_producto);
    }

    // 3. Limpiar el carrito
    $sql_delete_carrito = "DELETE FROM carrito WHERE usuario_id = '$usuario_id'";
    $conn->query($sql_delete_carrito);

    // Confirmar transacción
    $conn->commit();

    header("Location: receipt.php?pedido_id=" . $pedido_id);

} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollback();
    echo "Error al procesar el pedido: " . $e->getMessage();
}
?>
