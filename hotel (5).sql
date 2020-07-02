-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2020 a las 20:22:45
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `ApPC` varchar(20) NOT NULL,
  `numTarjeta` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `ApPC`, `numTarjeta`) VALUES
(456, 'Josefina', 'Dominguez', 2147483647),
(457, 'Mario', 'Gutierrez', 2147483489),
(459, 'Fabiola', 'Vargas', 1111111111),
(460, 'Pedro', 'Morales', 777777),
(467, 'Pablo', 'Duran', 7845123698265666),
(468, 'Enrique', 'Mendoza', 8888888888888888),
(469, 'Lourdes', 'Jimenez', 4152639874266332),
(473, 'Ramon', 'Perez', 7182934152637485),
(474, 'Erick ', 'Anizar', 6666898987474),
(475, 'Fabiola', 'Lopez', 2020202020202020),
(479, 'Joe', 'Rogan', 7474748844444844),
(481, 'Jaime', 'Rodriguez', 2020201515151515),
(482, 'Fabiola', 'Vargasyosa', 1811811818181888),
(509, 'Pedro', 'picapiedra', 5555555555555555),
(521, 'Lourdes', 'morales', 1948753625942555),
(522, 'Andres', 'Lopez', 1313131313133131),
(523, 'Fabio', 'Gutierrez', 1236589624585478),
(524, 'Fabiola', 'Beltran', 1818818881881818),
(525, 'Hector', 'Herrera', 4444444444888888),
(526, 'Guillermo', 'Ochoa', 7777778888888811),
(527, 'Fernando', 'Enriquez', 3333333333330000),
(528, 'Mario', 'Bros', 7778885556669944),
(529, 'Luigi', 'Bros', 333515162262626),
(530, 'Calamardo', 'Tentaculos', 121245478523658),
(531, 'Enrique', 'Epasote', 12345678910),
(532, 'Ariadna', 'Yañez', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habitacion` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `piso` int(11) NOT NULL,
  `amenidades` text NOT NULL,
  `id_tipo_habitacion` int(11) NOT NULL,
  `activo` char(1) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `numero`, `piso`, `amenidades`, `id_tipo_habitacion`, `activo`) VALUES
(1, 101, 1, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(2, 102, 1, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(3, 103, 1, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(4, 104, 1, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(5, 105, 1, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(6, 106, 1, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(7, 201, 2, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(8, 202, 2, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(9, 203, 2, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(10, 204, 2, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(11, 205, 2, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(12, 206, 2, 'Sin frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(13, 301, 3, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(14, 302, 3, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(15, 303, 3, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(16, 304, 3, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(17, 305, 3, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(18, 306, 3, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(19, 401, 4, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(20, 402, 4, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(21, 403, 4, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(22, 404, 4, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(23, 405, 4, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(24, 406, 4, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 1, 'S'),
(25, 501, 5, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 2, 'S'),
(26, 502, 5, 'Frigobar,Aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 2, 'S'),
(27, 503, 5, 'Frigobar, aire acondicionado, televisión, despertador, secadora, plancha, cafetera', 2, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion`
--

CREATE TABLE `reservacion` (
  `numero_personas` int(11) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `estatus` varchar(15) NOT NULL,
  `id_usr` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `monto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reservacion`
--

INSERT INTO `reservacion` (`numero_personas`, `check_in`, `check_out`, `id_habitacion`, `estatus`, `id_usr`, `id_cliente`, `monto`) VALUES
(1, '2020-01-01 20:30:00', '2020-01-11 20:30:00', 1, 's', 12, 467, 2500),
(2, '2020-01-01 20:30:00', '2020-01-11 20:30:00', 3, 's', 12, 474, 5000),
(1, '2020-01-01 20:30:00', '2020-01-11 20:30:00', 13, 's', 12, 473, 3750),
(1, '2020-02-01 20:30:00', '2020-02-11 20:30:00', 4, 's', 12, 530, 5000),
(1, '2020-06-27 17:00:00', '2020-06-28 17:00:00', 25, 's', 12, 532, 3000),
(1, '2020-08-30 20:30:00', '2020-09-01 20:30:00', 1, 's', 12, 482, 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_habitacion`
--

CREATE TABLE `tipo_habitacion` (
  `id_tipo_habitacion` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `activo` char(1) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_habitacion`
--

INSERT INTO `tipo_habitacion` (`id_tipo_habitacion`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'Estándar', 'Habitación con una cama individual, baño y escritorio', 'S'),
(2, 'Junior suite', 'Habitación suite con cama Queen size, cafetera, televisor y baño con tina', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usr` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `puesto` varchar(30) NOT NULL,
  `nombreU` varchar(20) NOT NULL,
  `ApPU` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usr`, `email`, `password`, `puesto`, `nombreU`, `ApPU`) VALUES
(12, 'victoranizarmorales@gmail.com', '123', 'Gerente', 'Víctor ', 'Anizar'),
(13, 'ingridalonzo2406@gmail.com', '123', 'Recepcionista', 'Ingrid', 'Garcia'),
(14, 'hec@hotmail.com', '123', 'Recepcionista', 'Hector', 'Gonzalez');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `numTarjeta` (`numTarjeta`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habitacion`),
  ADD KEY `fkHabitacionTipo` (`id_tipo_habitacion`);

--
-- Indices de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD PRIMARY KEY (`check_in`,`id_habitacion`,`id_usr`,`id_cliente`),
  ADD KEY `fkreservacionCte` (`id_cliente`),
  ADD KEY `fkreservacionUsr` (`id_usr`),
  ADD KEY `fkreservacionHab` (`id_habitacion`);

--
-- Indices de la tabla `tipo_habitacion`
--
ALTER TABLE `tipo_habitacion`
  ADD PRIMARY KEY (`id_tipo_habitacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usr`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=533;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `tipo_habitacion`
--
ALTER TABLE `tipo_habitacion`
  MODIFY `id_tipo_habitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `fkHabitacionTipo` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`);

--
-- Filtros para la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD CONSTRAINT `fkreservacionCte` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fkreservacionHab` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`),
  ADD CONSTRAINT `fkreservacionUsr` FOREIGN KEY (`id_usr`) REFERENCES `usuario` (`id_usr`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
