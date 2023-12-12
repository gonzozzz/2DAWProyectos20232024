-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2023 a las 20:31:45
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gaming`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `id_incidencia` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `fecha_incidencia` date NOT NULL,
  `incidencia` varchar(250) NOT NULL,
  `email_afectado` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia_pc`
--

CREATE TABLE `incidencia_pc` (
  `id_incidencia_pc` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fecha_incidencia` date NOT NULL,
  `incidencia` varchar(60) NOT NULL,
  `email` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pc`
--

CREATE TABLE `pc` (
  `id` int(11) NOT NULL,
  `estado` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `pc`
--

INSERT INTO `pc` (`id`, `estado`) VALUES
(1, 'Correcto'),
(2, 'Correcto'),
(3, 'Correcto'),
(4, 'Correcto'),
(5, 'Correcto'),
(6, 'Correcto'),
(7, 'Correcto'),
(8, 'Correcto'),
(9, 'Correcto'),
(10, 'Correcto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservar`
--

CREATE TABLE `reservar` (
  `email` varchar(60) NOT NULL,
  `id` int(11) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `turno` varchar(10) NOT NULL,
  `incidencia` varchar(250) DEFAULT 'No',
  `responsable` varchar(2) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `email` varchar(60) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `contra` varchar(20) DEFAULT NULL,
  `fecha_alta` date NOT NULL,
  `vetado` date DEFAULT NULL,
  `info_vetado` varchar(40) DEFAULT NULL,
  `pc_reservados` int(11) NOT NULL,
  `permisos` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `nombre`, `apellido`, `contra`, `fecha_alta`, `vetado`, `info_vetado`, `pc_reservados`, `permisos`) VALUES
('beatriz.torronfernandez@educa.madrid.org', 'Beatriz', 'Torron', 'ies0304', '2023-12-05', NULL, NULL, 0, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`email`,`id_incidencia`,`fecha_incidencia`),
  ADD KEY `id_incidencia` (`id_incidencia`);

--
-- Indices de la tabla `incidencia_pc`
--
ALTER TABLE `incidencia_pc`
  ADD PRIMARY KEY (`id_incidencia_pc`,`id`,`fecha_incidencia`),
  ADD UNIQUE KEY `id_incidencia_pc` (`id_incidencia_pc`),
  ADD KEY `id` (`id`),
  ADD KEY `email` (`email`);

--
-- Indices de la tabla `pc`
--
ALTER TABLE `pc`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservar`
--
ALTER TABLE `reservar`
  ADD PRIMARY KEY (`email`,`id`,`fecha_reserva`),
  ADD KEY `fk_reservar_id` (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `incidencia_pc`
--
ALTER TABLE `incidencia_pc`
  MODIFY `id_incidencia_pc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_incidencia_email` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`);

--
-- Filtros para la tabla `incidencia_pc`
--
ALTER TABLE `incidencia_pc`
  ADD CONSTRAINT `incidencia_pc_ibfk_1` FOREIGN KEY (`id`) REFERENCES `pc` (`id`),
  ADD CONSTRAINT `incidencia_pc_ibfk_2` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`);

--
-- Filtros para la tabla `reservar`
--
ALTER TABLE `reservar`
  ADD CONSTRAINT `fk_reservar_email` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`),
  ADD CONSTRAINT `fk_reservar_id` FOREIGN KEY (`id`) REFERENCES `pc` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
