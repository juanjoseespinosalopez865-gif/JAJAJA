<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['es_admin'] != 1) {
    header("Location: ../auth/login.php");
    exit();
}

// Obtener usuarios
$sql_usuarios = "SELECT id, nombre, email FROM usuarios";
$result_usuarios = $conn->query($sql_usuarios);

// Obtener pedidos
$sql_pedidos = "SELECT p.id, u.nombre as usuario_nombre, p.fecha, p.estado FROM pedidos p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.fecha DESC";
$result_pedidos = $conn->query($sql_pedidos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Panel de Administración</h2>

        <h3>Usuarios</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acción</th>
            </tr>
            <?php
            if ($result_usuarios->num_rows > 0) {
                while($row = $result_usuarios->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td><a href='delete_user.php?id=" . $row["id"] . "'>Eliminar</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay usuarios</td></tr>";
            }
            ?>
        </table>

        <h3 style="margin-top: 40px;">Pedidos</h3>
        <table>
            <tr>
                <th>ID Pedido</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            <?php
            if ($result_pedidos->num_rows > 0) {
                while($row = $result_pedidos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["usuario_nombre"] . "</td>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "<td>" . $row["estado"] . "</td>";
                    echo "<td>";
                    if ($row["estado"] == 'Pendiente') {
                        echo "<a href='cancel_order.php?id=" . $row["id"] . "'>Cancelar</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay pedidos</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
