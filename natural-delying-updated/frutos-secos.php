<?php
session_start();
include 'config/db.php';

$sql = "SELECT * FROM productos WHERE categoria = 'fruto-seco'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Frutos Secos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>NATURAL DELYING</h1>
        <nav>
            <a href="index.php">INICIO</a>
            <a href="productos.php">PRODUCTOS</a>
            <a href="cart/view_cart.php">CARRITO</a>
        </nav>
        <div class="user-icon">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="cart/view_cart.php">🛒</a>
                <a href="auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="auth/login.php">👤</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <h2>Nuestros Frutos Secos</h2>
        <div class="product-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product-item'>";
                    echo "<img src='" . $row["imagen"] . "' alt='" . $row["nombre"] . "'>";
                    echo "<h3>" . $row["nombre"] . "</h3>";
                    echo "<p>" . $row["descripcion"] . "</p>";
                    echo "<p>Precio: $" . $row["precio"] . "</p>";
                    echo "<form action='cart/add_to_cart.php' method='post'>";
                    echo "<input type='hidden' name='producto_id' value='" . $row["id"] . "'>";
                    echo "<button type='submit'>Añadir al Carrito</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "No hay frutos secos disponibles.";
            }
            ?>
        </div>
    </div>
</body>
</html>
