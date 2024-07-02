-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2023 a las 07:28:58
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_empleado` (IN `nomina` SMALLINT)   BEGIN
DELETE FROM empleado WHERE PK_nomina=nomina;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `PK_codigo` bigint(20) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apep` varchar(50) DEFAULT NULL,
  `apem` varchar(50) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`PK_codigo`, `nombre`, `apep`, `apem`, `telefono`, `direccion`, `correo`) VALUES
(8, 'Rodrigo', 'Romero', 'Corvera', '3316346586', 'paseo del bosque', 'rocobros21@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `PK_codigo` tinyint(4) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`PK_codigo`, `nombre`) VALUES
(1, 'RH'),
(2, 'Ventas'),
(3, 'Gerencia'),
(4, 'Almacen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `des_factura`
--

CREATE TABLE `des_factura` (
  `PK_des` mediumint(9) NOT NULL,
  `FK_factura` mediumint(9) DEFAULT NULL,
  `FK_producto` bigint(20) DEFAULT NULL,
  `cantidad` tinyint(4) DEFAULT NULL,
  `subtotal` decimal(8,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `des_factura`
--

INSERT INTO `des_factura` (`PK_des`, `FK_factura`, `FK_producto`, `cantidad`, `subtotal`) VALUES
(120, 37, 7, 2, '201.98'),
(121, 37, 7, 1, '100.99');

--
-- Disparadores `des_factura`
--
DELIMITER $$
CREATE TRIGGER `act_del_total` AFTER DELETE ON `des_factura` FOR EACH ROW BEGIN
UPDATE factura
SET total = (
SELECT SUM(subtotal)
FROM des_factura
WHERE factura.PK_factura=OLD.FK_factura
)
WHERE PK_factura=OLD.FK_factura;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `act_update_total` AFTER UPDATE ON `des_factura` FOR EACH ROW UPDATE factura AS f
SET total = (
SELECT SUM(subtotal)
FROM des_factura
WHERE FK_factura = f.PK_factura
)
WHERE f.PK_factura = NEW.FK_factura
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_factura_total` AFTER INSERT ON `des_factura` FOR EACH ROW BEGIN
UPDATE factura AS f
SET total = (
SELECT SUM(subtotal)
FROM des_factura
WHERE FK_factura = f.PK_factura
)
WHERE f.PK_factura = NEW.FK_factura;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `PK_matricula` smallint(6) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apep` varchar(50) DEFAULT NULL,
  `apem` varchar(50) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `turno` varchar(1) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `FK_depa` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`PK_matricula`, `nombre`, `apep`, `apem`, `fecha_ingreso`, `turno`, `telefono`, `direccion`, `correo`, `FK_depa`) VALUES
(14, 'Albert', 'Wachi', 'Pena', '0000-00-00', 'M', '3312345678', 'ceti', 'albert@gmail.com', 2),
(15, 'Diego', 'Romero', 'Corvera', '2023-06-04', 'V', '123', 'sdfsdf', 'sdfsdf', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `PK_factura` mediumint(9) NOT NULL,
  `FK_empleado` smallint(6) DEFAULT NULL,
  `FK_cliente` bigint(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total` decimal(8,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`PK_factura`, `FK_empleado`, `FK_cliente`, `fecha`, `total`) VALUES
(37, 14, 8, '2023-06-04', '302.97');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `PK_codigo` bigint(20) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `condicion` varchar(1) DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`PK_codigo`, `nombre`, `descripcion`, `condicion`, `precio`) VALUES
(7, 'Mouse inalambrico', 'mouse logitech 123', 'N', '100.99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id` tinyint(4) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contra` varchar(50) DEFAULT NULL,
  `tipo` varchar(1) NOT NULL DEFAULT '0',
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`id`, `usuario`, `contra`, `tipo`, `email`) VALUES
(1, 'admin_rodrigo', '827ccb0eea8a706c4c34a16891f84e7b', '0', NULL),
(3, 'Rocobros', 'cf096a375a3b57fe477cbdc80057f07a', '1', 'rocobros21@gmail.com'),
(4, 'Rodrigo', '827ccb0eea8a706c4c34a16891f84e7b', '1', 'rocobros21@gmail.com');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_factura`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_factura` (
`Numero` mediumint(9)
,`Nombre_cliente` varchar(50)
,`Apellido_cliente` varchar(50)
,`Nombre_empleado` varchar(50)
,`Apellido_empleado` varchar(50)
,`fecha` date
,`total` decimal(8,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_subtotal`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_subtotal` (
`PK_factura` mediumint(9)
,`FK_producto` bigint(20)
,`cantidad` tinyint(4)
,`subtotal` decimal(8,2)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_factura`
--
DROP TABLE IF EXISTS `v_factura`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_factura`  AS SELECT `factura`.`PK_factura` AS `Numero`, `cliente`.`nombre` AS `Nombre_cliente`, `cliente`.`apep` AS `Apellido_cliente`, `empleado`.`nombre` AS `Nombre_empleado`, `empleado`.`apep` AS `Apellido_empleado`, `factura`.`fecha` AS `fecha`, `factura`.`total` AS `total` FROM ((`factura` join `cliente` on(`factura`.`FK_cliente` = `cliente`.`PK_codigo`)) join `empleado` on(`factura`.`FK_empleado` = `empleado`.`PK_matricula`))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_subtotal`
--
DROP TABLE IF EXISTS `v_subtotal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_subtotal`  AS SELECT `factura`.`PK_factura` AS `PK_factura`, `des_factura`.`FK_producto` AS `FK_producto`, `des_factura`.`cantidad` AS `cantidad`, `des_factura`.`subtotal` AS `subtotal` FROM (`factura` left join `des_factura` on(`des_factura`.`FK_factura` = `factura`.`PK_factura`))  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`PK_codigo`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`PK_codigo`);

--
-- Indices de la tabla `des_factura`
--
ALTER TABLE `des_factura`
  ADD PRIMARY KEY (`PK_des`),
  ADD KEY `FK_producto` (`FK_producto`),
  ADD KEY `FK_factura` (`FK_factura`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`PK_matricula`),
  ADD KEY `FK_depa` (`FK_depa`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`PK_factura`),
  ADD KEY `FK_empleado` (`FK_empleado`),
  ADD KEY `FK_cliente` (`FK_cliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`PK_codigo`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `PK_codigo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `PK_codigo` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `des_factura`
--
ALTER TABLE `des_factura`
  MODIFY `PK_des` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `PK_matricula` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `PK_factura` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `PK_codigo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `des_factura`
--
ALTER TABLE `des_factura`
  ADD CONSTRAINT `des_factura_ibfk_2` FOREIGN KEY (`FK_producto`) REFERENCES `producto` (`PK_codigo`),
  ADD CONSTRAINT `des_factura_ibfk_3` FOREIGN KEY (`FK_factura`) REFERENCES `factura` (`PK_factura`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`FK_depa`) REFERENCES `departamento` (`PK_codigo`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`FK_empleado`) REFERENCES `empleado` (`PK_matricula`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`FK_cliente`) REFERENCES `cliente` (`PK_codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
