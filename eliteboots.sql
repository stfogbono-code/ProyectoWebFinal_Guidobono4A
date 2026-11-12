-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2026 a las 01:51:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eliteboots`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `botines`
--

CREATE TABLE `botines` (
  `id` int(10) UNSIGNED NOT NULL,
  `marca` varchar(70) NOT NULL,
  `modelo` varchar(70) NOT NULL,
  `talle` tinyint(3) UNSIGNED NOT NULL,
  `precio` decimal(14,2) NOT NULL,
  `descripcion` text NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `archivado_en` datetime DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `botines`
--

INSERT INTO `botines` (`id`, `marca`, `modelo`, `talle`, `precio`, `descripcion`, `creado_en`, `archivado_en`, `imagen`) VALUES
(1, 'Nike', 'Mercurial', 42, 189000.00, 'Botines para césped natural.', '2026-11-11 19:44:54', NULL, 'img/449e8bee5e8db71bed3d4d6c52e33ca7.webp'),
(2, 'Adidas', 'Predator', 41, 165000.00, 'Botines para césped natural.', '2026-11-11 19:44:54', NULL, 'img/00f8cb16c8be4bdc166d88462c3667d4.jpg'),
(3, 'Puma', 'Future', 43, 142000.00, 'Botines para césped natural.', '2026-11-11 19:44:54', NULL, 'img/7093f6766c4219e0d83b86588f4dbc83.png'),
(4, 'Nike', 'Tiempo', 40, 170000.00, 'Botines para césped natural.', '2026-11-11 20:03:45', NULL, 'img/4963b0d2c1ccce379d8b52e1e3fe66f7.png'),
(5, 'Adidas', 'F50', 41, 234999.00, 'Botines para césped natural.', '2026-11-11 20:04:20', NULL, 'img/74c41442ae34b659c7e5083a438d6d1d.webp'),
(6, 'Joma', 'Top Flex', 39, 135999.00, 'Botines para futsal. Indoor.', '2026-11-11 20:05:45', NULL, 'img/797f2f3579ca40ef91b6729337f3cf12.webp'),
(7, 'Nike', 'Phantom', 37, 169999.00, 'Botines para césped natural.', '2026-11-11 20:27:52', NULL, 'img/21b05125ad342cc200ba85590d29c17d.jpg'),
(8, 'Puma', 'Borussia', 44, 199999.00, 'Botines para césped natural.', '2026-11-11 20:28:11', NULL, 'img/47d29c7e8b72db4c87845bd9513e02c7.webp'),
(9, 'Nike', 'Hypervenom Phantom 1', 41, 239999.00, 'Botines para césped natural.', '2026-11-11 20:29:13', NULL, 'img/692e8d79532f73ecaaa0bc3c7fccdb1a.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `clave_hash` varchar(255) NOT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `archivado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `dni`, `correo`, `clave_hash`, `rol`, `creado_en`, `archivado_en`) VALUES
(1, 'Stefo', 'Guidobono', '50211234', 'stefoadmin@gmail.com', '$2y$10$DEjYh0Ko7tMVyufE7xVLPOIGhSs1UVif0pd4tddpvhZ5y52ht3UZq', 'admin', '2026-11-11 19:46:08', NULL),
(2, 'Stefo', 'Guidobono', '20384435', 'stefuser@gmail.com', '$2y$10$susJXfqv9KNFstMMIYLrr.qEw0po7NXnhp2b0LC.Si2BlHfg7phoy', 'usuario', '2026-11-11 20:31:00', NULL),
(3, 'Mauro', 'Bobyk', '20123456', 'bobyk@gmail.com', '$2y$10$U6D6FKTI4XwxDTUxfevg.u52kqcH5NLlwTn6OZKQ0tCtmBxBzUHJa', 'usuario', '2026-11-11 20:31:59', NULL),
(4, 'Alan', 'Acosta', '20565321', 'alan@gmail.com', '$2y$10$sQHena/FSU2l/bYpCcm2H.wjc2Dx1fvvVZkNFcqNDoISWQQqHUzia', 'usuario', '2026-11-11 21:24:07', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `botines`
--
ALTER TABLE `botines`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `botines`
--
ALTER TABLE `botines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
