-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `natural_delying`;
USE `natural_delying`;

-- Tabla de usuarios
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar el usuario administrador
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `es_admin`) VALUES
('Admin', 'admin@gmail.com', '$2y$10$QyjzyRS2tZeXpgv8sd419OvNtR//0JUjZEm0jvufT6xngmHgpvyuG', 1);

-- Tabla de productos
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar algunos productos de ejemplo
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `imagen`) VALUES
('Jugo de Fresa', 'Refrescante jugo de fresa natural.', 2.50, 'IMG_Jugos/jugo_fresa.jpg'),
('Jugo de Guanábana', 'Exótico jugo de guanábana.', 3.00, 'IMG_Jugos/jugo_guanabana.jpg'),
('Jugo de Guayaba', 'Dulce jugo de guayaba.', 2.75, 'IMG_Jugos/jugo_guayaba.jpg'),
('Jugo de Mango', 'Delicioso jugo de mango.', 2.80, 'IMG_Jugos/jugo_mango.jpg'),
('Almendras', 'Un snack saludable y delicioso.', 5.00, 'IMG_Frutos_Secos/almendras.png'),
('Nueces', 'Ricas en nutrientes y sabor.', 6.00, 'IMG_Frutos_Secos/nueces.png');

-- Tabla del carrito
CREATE TABLE `carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
