-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-03-2025 a las 17:42:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambiente`
--

CREATE TABLE `ambiente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambiente`
--

INSERT INTO `ambiente` (`id`, `nombre`) VALUES
(1, 'sistemas 1'),
(2, 'sistemas 4'),
(3, 'sistemas 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `hora1` enum('A','F','I') NOT NULL,
  `hora2` enum('A','F','I') NOT NULL,
  `hora3` enum('A','F','I') NOT NULL,
  `fkidficha` int(11) NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aprendices`
--

INSERT INTO `aprendices` (`id`, `nombre`, `hora1`, `hora2`, `hora3`, `fkidficha`, `fecha`) VALUES
(1, 'Levia', 'A', 'A', 'A', 1, '2025-03-14'),
(2, 'Carlos', 'F', 'A', 'I', 1, '2025-03-14'),
(3, 'María', 'A', 'A', 'F', 2, '2025-03-15'),
(4, 'José', 'A', 'I', 'A', 2, '2025-03-15'),
(5, 'Ana', 'A', 'I', 'F', 3, '2025-03-16'),
(6, 'Pedro', 'F', 'F', 'A', 3, '2025-03-16'),
(7, 'Lucía', 'I', 'A', 'A', 4, '2025-03-17'),
(8, 'Juan', 'A', 'F', 'F', 4, '2025-03-17'),
(9, 'Sofía', 'A', 'A', 'I', 5, '2025-03-18'),
(10, 'Diego', 'I', 'I', 'F', 5, '2025-03-18');

--
-- Disparadores `aprendices`
--
DELIMITER $$
CREATE TRIGGER `before_insert_aprendices` BEFORE INSERT ON `aprendices` FOR EACH ROW BEGIN
  IF NEW.hora2 IS NULL THEN
    SET NEW.hora2 = ''; -- O el valor predeterminado que elijas.  Asegúrate de que esté dentro de los valores permitidos por el ENUM.
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `L` char(1) DEFAULT NULL,
  `M` char(1) DEFAULT NULL,
  `Mi` char(1) DEFAULT NULL,
  `J` char(1) DEFAULT NULL,
  `V` char(1) DEFAULT NULL,
  `faltas` int(11) DEFAULT 5,
  `ficha_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id`, `id_estudiante`, `L`, `M`, `Mi`, `J`, `V`, `faltas`, `ficha_id`) VALUES
(1, 1, '0', '0', '0', '0', '1', 5, 0),
(2, 2, '1', '1', '1', '1', '1', 5, 0),
(3, 3, '1', '1', '1', '0', '0', 5, 0),
(4, 11, '1', '1', '0', '0', '0', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE `coordinador` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('coordinador') NOT NULL DEFAULT 'coordinador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`id`, `username`, `password_hash`, `role`) VALUES
(1, 'ferney', '$2y$10$Ox12ZoRXI3KgRO1mm7yMteZUQdv0eu0INoxVx.WCsk/M8nEjlAkYK', 'coordinador'),
(2, 'luis', '$2y$10$s1.4PAca5UGZj/v/GA/vZ.uvmLt/fZEmlCjfngP7YmX6.iVVDmdvO', 'coordinador'),
(3, 'instructor', '$2y$10$dmQYjT1poPzU1kQXXSg.5OWyciD9kBdmmrWGBsCTdvBBfOjdgysMq', 'coordinador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ficha_id` int(11) NOT NULL,
  `hora1` varchar(1) DEFAULT NULL,
  `hora2` varchar(1) DEFAULT NULL,
  `hora3` varchar(1) DEFAULT NULL,
  `L` tinyint(4) DEFAULT 0,
  `M` tinyint(4) DEFAULT 0,
  `Mi` tinyint(4) DEFAULT 0,
  `J` tinyint(4) DEFAULT 0,
  `V` tinyint(4) DEFAULT 0,
  `faltas` int(11) DEFAULT 0,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `nombre`, `ficha_id`, `hora1`, `hora2`, `hora3`, `L`, `M`, `Mi`, `J`, `V`, `faltas`, `fecha`) VALUES
(1, 'laura', 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 3, NULL),
(2, 'jose', 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 4, NULL),
(3, 'ferney', 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 4, NULL),
(4, 'dana', 1, 'A', 'I', 'A', 0, 1, 0, 0, 0, 0, NULL),
(6, 'yury', 2, 'A', 'A', 'A', 0, 0, 0, 0, 0, 0, NULL),
(9, 'dayana', 3, 'I', 'I', 'I', 0, 0, 0, 0, 0, 0, NULL),
(10, 'dayana', 1, 'A', 'A', 'A', 0, 0, 0, 0, 0, 0, NULL),
(11, 'jose luis', 1, 'I', 'I', 'I', 0, 0, 0, 0, 0, 0, NULL),
(12, 'chajan', 3, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL),
(13, 'fer', 1, 'I', 'I', 'I', 0, 0, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` int(11) NOT NULL,
  `ficha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`id`, `ficha`) VALUES
(1, '2873707'),
(2, '8291939'),
(3, '12345678');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gerente`
--

CREATE TABLE `gerente` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('super_admin','ultra_admin','coordinador','instructor','aprendiz') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gerente`
--

INSERT INTO `gerente` (`id`, `username`, `password_hash`, `role`) VALUES
(1, 'ultra_admin', '$2y$10$g7ukn8.f7AOl7TVLeOsMmu5BsygIV8BlGQy1w63s/rxksZ5wo.Io2', 'ultra_admin'),
(2, 'super_admin', '$2y$10$j7WHtoI7.vRbOQjcJMGF8eR/E5UlGVCEHXrTsGi/4RyYcdGkGcut.', 'super_admin'),
(3, 'coordinador', '$2y$10$tM824MBX/2VZcA2iFRQdK.STMakPw8NxQyvGSDNiSEFwMbDUWK2ca', 'coordinador'),
(4, 'instructor', '$2y$10$DW8MBk8DvY8veRGUWy6gHeKF/0I0UPbU0hZvvdbjx2oceBRoVymo2', 'aprendiz'),
(5, 'aprendiz', '$2y$10$bG0pspXl/C6jVnF0xwlxr.WP2CqtwwOJN.6M0sBA1n8AbkTaPfIiO', 'aprendiz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`id`, `username`, `password_hash`, `role`) VALUES
(1, 'luisa', '$2y$10$lON6J6f6YgzjzT2vpjksIeIOTbNj8aKd6GK6RHNHNb6WeHiJiqJwG', 'instructor'),
(2, 'fer', '$2y$10$RATDoNBetv.0tJkI6uEMceJDKN6fKiMFCvLonRUvUSySgtfnf9GpW', 'instructor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa_formacion`
--

CREATE TABLE `programa_formacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programa_formacion`
--

INSERT INTO `programa_formacion` (`id`, `nombre`) VALUES
(1, 'computador de mesa'),
(2, 'cafetera'),
(3, 'cafetera');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambiente`
--
ALTER TABLE `ambiente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gerente`
--
ALTER TABLE `gerente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `programa_formacion`
--
ALTER TABLE `programa_formacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambiente`
--
ALTER TABLE `ambiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `gerente`
--
ALTER TABLE `gerente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `programa_formacion`
--
ALTER TABLE `programa_formacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
