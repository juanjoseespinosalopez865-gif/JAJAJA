<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['pedido_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$pedido_id = $_GET['pedido_id'];
$usuario_id = $_SESSION['usuario_id'];

// Verificar que el pedido pertenece al usuario
$sql_pedido = "SELECT * FROM pedidos WHERE id = '$pedido_id' AND usuario_id = '$usuario_id'";
$result_pedido = $conn->query($sql_pedido);

if ($result_pedido->num_rows == 0) {
    echo "Pedido no encontrado.";
    exit();
}

$sql_productos = "SELECT p.nombre, pp.cantidad, pp.precio FROM pedido_productos pp JOIN productos p ON pp.producto_id = p.id WHERE pp.pedido_id = '$pedido_id'";
$result_productos = $conn->query($sql_productos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Compra</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Recibo de Compra</h2>
        <p>¡Gracias por tu compra! Tu pedido #<?php echo $pedido_id; ?> ha sido recibido.</p>
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
            <?php
            $total_pedido = 0;
            if ($result_productos->num_rows > 0) {
                while($row = $result_productos->fetch_assoc()) {
                    $total_producto = $row["precio"] * $row["cantidad"];
                    $total_pedido += $total_producto;
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>$" . $row["precio"] . "</td>";
                    echo "<td>$" . number_format($total_producto, 2) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
            <tr>
                <td colspan="3"><strong>Total Pagado</strong></td>
                <td><strong>$<?php echo number_format($total_pedido, 2); ?></strong></td>
            </tr>
        </table>
        <a href="../index.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>
