SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `clientes` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(50) NOT NULL,
  `correo_electronico` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `fecha_registro` date
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `productos` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `codigo_producto` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio` DECIMAL(10, 2),
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pedidos` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `id_cliente` INT,
  `fecha_pedido` date,
  `estado` varchar(50) NOT NULL,
  `total` DECIMAL(10, 2),
  FOREIGN KEY (`id_cliente`) REFERENCES `clientes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `detalles_pedidos` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `id_pedido` INT,
  `id_producto` INT,
  `cantidad` INT NOT NULL,
  `precio` DECIMAL(10, 2),
  FOREIGN KEY (`id_pedido`) REFERENCES `pedidos`(`id`),
  FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pedidos_historicos` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `id_pedido` INT,
  `total` DECIMAL(10, 2),
  FOREIGN KEY (`id_pedido`) REFERENCES `pedidos`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ventas` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `id_pedido` INT,
  `fecha_pedido` date,
  `total` DECIMAL(10, 2),
  FOREIGN KEY (`id_pedido`) REFERENCES `pedidos`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `facturas` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `id_cliente` INT,
  `id_pedido` INT,
  `monto` DECIMAL(10, 2),
  `fecha_emision` date,
  `estado_pago` varchar(50),
  FOREIGN KEY (`id_cliente`) REFERENCES `clientes`(`id`),
  FOREIGN KEY (`id_pedido`) REFERENCES `pedidos`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;