<?php
session_start();
include 'config/db.php';

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
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
        <div class="user-icon">👤</div>
    </div>
    <div class="container">
        <h2>Nuestros Productos</h2>
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
                echo "No hay productos disponibles.";
            }
            ?>
        </div>
    </div>
</body>
</html>
