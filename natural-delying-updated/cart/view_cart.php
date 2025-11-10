<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT p.nombre, p.precio, c.cantidad FROM carrito c JOIN productos p ON c.producto_id = p.id WHERE c.usuario_id = '$usuario_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Carrito de Compras</h2>
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
            <?php
            $total_carrito = 0;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $total_producto = $row["precio"] * $row["cantidad"];
                    $total_carrito += $total_producto;
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>$" . $row["precio"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>$" . number_format($total_producto, 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>El carrito está vacío</td></tr>";
            }
            ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>$<?php echo number_format($total_carrito, 2); ?></strong></td>
            </tr>
        </table>
        <a href="checkout.php" class="btn">Comprar</a>
    </div>
</body>
</html>
