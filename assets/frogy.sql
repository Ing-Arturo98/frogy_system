-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-12-2023 a las 16:34:00
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `frogy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_producto` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_carrito` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_producto`, `id_usuario`, `id_carrito`) VALUES
(15, 8, 147),
(16, 8, 148),
(21, 8, 149),
(16, 8, 150),
(16, 1, 151),
(16, 1, 152);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `estatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `estatus`) VALUES
(1, 'maquillaje', 'activo'),
(2, 'accesorios', 'activo'),
(3, 'colecciones', 'activo'),
(4, 'comestible', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `fechaNac` varchar(30) DEFAULT NULL,
  `codPos` varchar(15) DEFAULT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `colonia` varchar(50) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `num_casa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombre_completo`, `fechaNac`, `codPos`, `telefono`, `correo`, `ciudad`, `colonia`, `calle`, `num_casa`) VALUES
(1, 'Aarón Arturo Romero Pech', '1998-01-15', '24028', '9811178153', 'arturoaaron2@gmail.com', 'San francisco de Campeche', 'Santa Lucia', 'Antigua a merida', '#7'),
(2, 'Venta P. General', '2023-08-03', '0', 'Venta P. General', 'Venta P. General', 'Venta P. General', 'Venta P. General', 'Venta P. General', 'Venta P. General');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notacompra`
--

CREATE TABLE `notacompra` (
  `id_nota` int NOT NULL,
  `fecha_hr` varchar(25) DEFAULT NULL,
  `total_compra` decimal(10,2) DEFAULT NULL,
  `idCliente` int NOT NULL,
  `id_vendedor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `notacompra`
--

INSERT INTO `notacompra` (`id_nota`, `fecha_hr`, `total_compra`, `idCliente`, `id_vendedor`) VALUES
(98, '10-08-2023', 644.38, 1, 1),
(99, '10-08-2023', 1166.38, 2, 1),
(100, '10-08-2023', 568.40, 2, 1),
(101, '10-08-2023', 452.40, 1, 1),
(102, '10-08-2023', 644.38, 2, 1),
(103, '10-08-2023', 487.20, 1, 1),
(104, '10-08-2023', 174.00, 2, 1),
(106, '11-08-2023', 1200.00, 2, 1),
(107, '11-08-2023', 555.00, 1, 1),
(108, '11-08-2023', 5373.00, 1, 1),
(109, '11-08-2023', 900.50, 1, 1),
(110, '12-08-2023', 750.50, 1, 1),
(111, '12-08-2023', 1215.00, 2, 1),
(112, '13-08-2023', 1000.00, 2, 1),
(113, '14-08-2023', 75.00, 1, 1),
(114, '14-08-2023', 55.50, 2, 1),
(115, '14-08-2023', 120.00, 1, 1),
(116, '15-08-2023', 813.50, 2, 1),
(117, '15-08-2023', 1320.50, 2, 1),
(118, '15-08-2023', 320.00, 1, 1),
(119, '15-08-2023', 1000.00, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int NOT NULL,
  `nombre` varchar(300) DEFAULT NULL,
  `categoria` varchar(40) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `estatus` varchar(20) NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombre`, `categoria`, `precio`, `estatus`, `img`) VALUES
(15, 'labial', '1', 50.50, 'escaso', '../img/productos/producto15.JPG'),
(16, 'sombra', '1', 555.50, 'disponible', '../img/productos/producto16.jpg'),
(21, 'pulcera ', '2', 105.50, 'disponible', '../img/productos/producto21.jpg'),
(108, 'Lápiz labial rojo intenso', '1', 120.00, 'disponible', '../img/productos/producto108.jpg'),
(109, 'Base de maquillaje líquida', '1', 250.00, 'disponible', '../img/productos/producto109.jpg'),
(110, 'Máscara de pestañas resistente al agua', '1', 180.00, 'escaso', '../img/productos/producto110.jpg'),
(111, 'Sombra de ojos en tono dorado', '1', 80.00, 'disponible', '../img/productos/producto111.jpg'),
(112, 'Brocha para polvos suaves', '2', 150.00, 'disponible', '../img/productos/producto112.jpg'),
(113, 'Bolso de mano estilo clutch', '2', 350.00, 'escaso', '../img/productos/producto113.jpg'),
(114, 'Collar de perlas elegante', '2', 220.00, 'disponible', '../img/productos/producto114.jpg'),
(115, 'Paleta de sombras con 12 tonos', '1', 180.00, 'agotado', '../img/productos/producto115.jpg'),
(116, 'Espejo de maquillaje plegable', '2', 120.00, 'disponible', '../img/productos/producto116.jpg'),
(117, 'Labial líquido mate en tono nude', '1', 150.00, 'disponible', '../img/productos/producto117.jpg'),
(118, 'Rubor en polvo compacto', '1', 100.00, 'escaso', '../img/productos/producto118.jpg'),
(119, 'Delineador de ojos en gel', '1', 90.00, 'disponible', '../img/productos/producto119.jpg'),
(120, 'Iluminador en crema', '1', 80.00, 'agotado', '../img/productos/producto120.jpg'),
(121, 'Set de 10 brochas profesionales', '2', 200.00, 'agotado', '../img/productos/producto121.jpg'),
(122, 'Bolso de hombro con estampado floral', '2', 120.00, 'disponible', '../img/productos/producto122.jpg'),
(123, 'Collar con dije de corazón', '2', 90.00, 'agotado', '../img/productos/producto123.jpg'),
(124, 'Kit de maquillaje para viaje', '1', 180.00, 'escaso', '../img/productos/producto124.jpg'),
(125, 'Espejo con luz LED', '2', 130.00, 'agotado', '../img/productos/producto125.jpg'),
(126, 'Labial en barra de larga duración', '1', 140.00, 'escaso', '../img/productos/producto126.jpg'),
(127, 'Bolso de playa con borlas', '2', 180.00, 'disponible', '../img/productos/producto127.jpg'),
(128, 'Pulsera de plata con piedras', '2', 90.00, 'escaso', '../img/productos/producto128.jpg'),
(129, 'Lápiz de cejas retráctil', '1', 70.00, 'escaso', '../img/productos/producto129.jpg'),
(130, 'Gloss labial hidratante', '1', 60.00, 'disponible', '../img/productos/producto130.jpg'),
(131, 'Cepillo desenredante para cabello', '2', 120.00, 'escaso', '../img/productos/producto131.jpg'),
(132, 'Set de sombras en tonos neutros', '1', 180.00, 'escaso', '../img/productos/producto132.jpg'),
(133, 'Bolso bandolera de cuero', '2', 250.00, 'disponible', '../img/productos/producto133.jpg'),
(134, 'Collar con colgante de mariposa', '2', 80.00, 'escaso', '../img/productos/producto134.jpg'),
(135, 'Rizador de pestañas profesional', '2', 90.00, 'escaso', '../img/productos/producto135.jpg'),
(136, 'Labial líquido mate en tono rosa', '1', 120.00, 'escaso', '../img/productos/producto136.jpg'),
(137, 'Brocha para contorno facial', '2', 80.00, 'disponible', '../img/productos/producto137.jpg'),
(138, 'Paleta de iluminadores', '1', 150.00, 'agotado', '../img/productos/producto138.jpg'),
(139, 'Espejo de mano plegable', '2', 70.00, 'escaso', '../img/productos/producto139.jpg'),
(140, 'Lápiz delineador de ojos retráctil', '1', 60.00, 'agotado', '../img/productos/producto140.jpg'),
(141, 'Set de aretes dorados', '2', 120.00, 'escaso', '../img/productos/producto141.jpg'),
(142, 'Máscara de pestañas de volumen', '1', 90.00, 'escaso', '../img/productos/producto142.jpg'),
(143, 'Cinturón de cuero con hebilla dorada', '2', 100.00, 'disponible', '../img/productos/producto143.jpg'),
(144, 'Labial líquido mate en tono rojo', '1', 120.00, 'agotado', '../img/productos/producto144.jpg'),
(145, 'Bolso de mano con flecos', '2', 180.00, 'escaso', '../img/productos/producto145.jpg'),
(146, 'Collar de perlas con dije de corazón', '2', 90.00, 'escaso', '../img/productos/producto146.jpg'),
(147, 'Paleta de sombras con tonos brillantes', '1', 200.00, 'escaso', '../img/productos/producto147.jpg'),
(148, 'Espejo de tocador con luz LED', '2', 250.00, 'agotado', '../img/productos/producto148.jpg'),
(149, 'Labial en barra de acabado satinado', '1', 120.00, 'agotado', '../img/productos/producto149.jpg'),
(150, 'Bolso cruzado con estampado animal', '2', 220.00, 'escaso', '../img/productos/producto150.jpg'),
(151, 'Collar con colgante de luna', '2', 80.00, 'disponible', '../img/productos/producto151.jpg'),
(152, 'Set de brochas para ojos', '2', 100.00, 'escaso', '../img/productos/producto152.jpg'),
(153, 'Delineador de ojos líquido de larga duración', '1', 80.00, 'agotado', '../img/productos/producto153.jpg'),
(154, 'Cepillo para desmaquillar', '2', 60.00, 'escaso', '../img/productos/producto154.jpg'),
(155, 'Set de pulseras con perlas y dijes', '2', 120.00, 'escaso', '../img/productos/producto155.jpg'),
(156, 'Lápiz de cejas con cepillo', '1', 70.00, 'agotado', '../img/productos/producto156.jpg'),
(157, 'Gloss labial con efecto voluminizador', '1', 90.00, 'agotado', '../img/productos/producto157.jpg'),
(158, 'Cepillo de cabello con cerdas de bambú', '2', 120.00, 'agotado', '../img/productos/producto158.jpg'),
(159, 'Set de sombras en tonos cálidos', '1', 180.00, 'escaso', '../img/productos/producto159.jpg'),
(160, 'Bolso de mano estilo tote', '2', 220.00, 'disponible', '../img/productos/producto160.jpg'),
(161, 'Collar con colgante de estrella', '2', 90.00, 'disponible', '../img/productos/producto161.jpg'),
(162, 'Rizador de pestañas con calentador', '2', 100.00, 'agotado', '../img/productos/producto162.jpg'),
(163, 'Labial líquido mate en tono marrón', '1', 120.00, 'agotado', '../img/productos/producto163.jpg'),
(164, 'Brocha para aplicar rubor', '2', 70.00, 'escaso', '../img/productos/producto164.jpg'),
(165, 'Paleta de contorno facial', '1', 150.00, 'escaso', '../img/productos/producto165.jpg'),
(166, 'Espejo de bolsillo con diseño floral', '2', 80.00, 'disponible', '../img/productos/producto166.jpg'),
(167, 'Lápiz delineador de ojos en gel', '1', 60.00, 'agotado', '../img/productos/producto167.jpg'),
(168, 'Set de aretes plateados', '2', 120.00, 'disponible', '../img/productos/producto168.jpg'),
(169, 'Máscara de pestañas alargadora', '1', 90.00, 'disponible', '../img/productos/producto169.jpg'),
(170, 'Cinturón de cuero con hebilla plateada', '2', 100.00, 'disponible', '../img/productos/producto170.jpg'),
(171, 'Labial líquido mate en tono morado', '1', 120.00, 'disponible', '../img/productos/producto171.jpg'),
(172, 'Bolso de hombro con detalles bordados', '2', 220.00, 'agotado', '../img/productos/producto172.jpg'),
(173, 'Collar con colgante de corazón y llave', '2', 90.00, 'agotado', '../img/productos/producto173.jpg'),
(174, 'Paleta de sombras con tonos mate', '1', 200.00, 'disponible', '../img/productos/producto174.jpg'),
(175, 'Espejo de mano con diseño vintage', '2', 180.00, 'agotado', '../img/productos/producto175.jpg'),
(176, 'Labial en barra de acabado satinado', '1', 120.00, 'escaso', '../img/productos/producto176.jpg'),
(177, 'Bolso cruzado con detalles metálicos', '2', 200.00, 'disponible', '../img/productos/producto177.jpg'),
(178, 'Collar con colgante de libélula', '2', 80.00, 'disponible', '../img/productos/producto178.jpg'),
(179, 'Set de brochas para rostro', '2', 100.00, 'agotado', '../img/productos/producto179.jpg'),
(180, 'Delineador de ojos en lápiz', '1', 80.00, 'disponible', '../img/productos/producto180.jpg'),
(181, 'Cepillo para limpiar el rostro', '2', 60.00, 'disponible', '../img/productos/producto181.jpg'),
(182, 'Set de pulseras con cuentas de colores', '2', 120.00, 'escaso', '../img/productos/producto182.jpg'),
(183, 'Lápiz de cejas retráctil con cepillo', '1', 70.00, 'escaso', '../img/productos/producto183.jpg'),
(184, 'Gloss labial hidratante en tono melocotón', '1', 90.00, 'escaso', '../img/productos/producto184.jpg'),
(185, 'Cepillo de cabello con diseño de mármol', '2', 120.00, 'disponible', '../img/productos/producto185.jpg'),
(186, 'Set de sombras en tonos fríos', '1', 180.00, 'agotado', '../img/productos/producto186.jpg'),
(187, 'Bolso de playa con detalles tejidos', '2', 180.00, 'escaso', '../img/productos/producto187.jpg'),
(188, 'Pulsera con cuentas de piedras naturales', '2', 90.00, 'disponible', '../img/productos/producto188.jpg'),
(189, 'Lápiz de ojos con esponja difuminadora', '1', 70.00, 'escaso', '../img/productos/producto189.jpg'),
(190, 'Labial en barra con acabado brillante', '1', 140.00, 'escaso', '../img/productos/producto190.jpg'),
(191, 'Cepillo de cabello con cerdas de nylon', '2', 100.00, 'agotado', '../img/productos/producto191.jpg'),
(192, 'Set de sombras en tonos pastel', '1', 200.00, 'disponible', '../img/productos/producto192.jpg'),
(193, 'Bolso de mano con detalles metálicos', '2', 220.00, 'escaso', '../img/productos/producto193.jpg'),
(194, 'pulsera dorada de oro', '2', 675.00, 'escaso', '../img/productos/producto194.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contraseña` varchar(20) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `nombre_usuario`, `contraseña`, `rol`, `correo`, `telefono`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin@admin.com', 'admin'),
(2, 'Cristian', 'cris', '12345', 'vendedor', 'cris@gmail.com', '9810001111'),
(7, 'Citlali Chávez', 'Chayo', 'admin', 'vendedor', 'admin2@gmail.com', '9812036930'),
(8, 'CINDY ZULEYMA', 'caja 1', '12345', 'vendedor', 'zulipego@gmail.com', '98100000');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `notacompra`
--
ALTER TABLE `notacompra`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notacompra`
--
ALTER TABLE `notacompra`
  MODIFY `id_nota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
