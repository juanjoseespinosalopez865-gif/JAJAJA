<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['es_admin'] != 1) {
    header("Location: ../auth/login.php");
    exit();
}

$sql = "SELECT id, nombre, email FROM usuarios";
$result = $conn->query($sql);
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
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acción</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
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
    </div>
</body>
</html>
