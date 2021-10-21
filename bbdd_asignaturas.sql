-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-09-2021 a las 20:53:14
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bbdd_asignaturas`
--
CREATE DATABASE IF NOT EXISTS `bbdd_asignaturas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bbdd_asignaturas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `creditos` int(11) NOT NULL,
  `duracion` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre`, `creditos`, `duracion`, `id_curso`) VALUES
(1, 'Bases de datos', 4, 200, 1),
(2, 'Programación', 7, 200, 1),
(3, 'Entornos de desarrollo', 3, 150, 1),
(5, 'Prevención de riegos laborales', 3, 100, 1),
(6, 'Lenguajes de marcas', 3, 160, 1),
(7, 'Manicura', 4, 100, 3),
(8, 'Técnicas de higiene facial y corporal', 4, 100, 3),
(9, 'Cosmetología para estética y belleza', 4, 100, 3),
(11, 'Empresas', 4, 100, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `curso` int(11) NOT NULL,
  `titulacion` varchar(500) NOT NULL,
  `duracion` int(11) NOT NULL,
  `anio` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `curso`, `titulacion`, `duracion`, `anio`) VALUES
(1, 1, 'Desarrollo de aplicaciones web (DAW)', 24, '2021-2022'),
(2, 2, 'Desarrollo de aplicaciones multiplataforma (DAM)', 24, '2021-2022'),
(3, 1, 'Estética y belleza', 24, '2021-2022'),
(4, 1, 'Administración de Sistemas Informáticos en Red', 24, '2021-2022');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioasignatura`
--

CREATE TABLE `usuarioasignatura` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarioasignatura`
--

INSERT INTO `usuarioasignatura` (`id`, `id_usuario`, `id_asignatura`) VALUES
(2, 1, 2),
(3, 1, 1),
(5, 6, 1),
(6, 6, 11),
(7, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(500) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `apellidos` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `pass` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellidos`, `email`, `pass`) VALUES
(1, 'mdire', 'Míriam', 'Díaz Redondo ', 'email@e.com', '202cb962ac59075b964b07152d234b70'),
(2, 'pepe93', 'Pepe', 'Rubio Rubio', 'email@email.com', '202cb962ac59075b964b07152d234b70'),
(6, 'juanco', 'Juan', 'Cortés Guzmán', 'juancogu@', 'a94652aa97c7211ba8954dd15a3cf838');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarioasignatura`
--
ALTER TABLE `usuarioasignatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_asignatura` (`id_asignatura`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarioasignatura`
--
ALTER TABLE `usuarioasignatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignaturas_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarioasignatura`
--
ALTER TABLE `usuarioasignatura`
  ADD CONSTRAINT `usuarioasignatura_ibfk_1` FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioasignatura_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
