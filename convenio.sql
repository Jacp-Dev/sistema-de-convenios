-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-09-2023 a las 23:14:49
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `convenio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat`
--

CREATE TABLE `cat` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `nacionalidad` varchar(50) NOT NULL,
  `caracteristica` varchar(50) NOT NULL,
  `tipo_convenio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `cat`
--

INSERT INTO `cat` (`id`, `nombre`, `nacionalidad`, `caracteristica`, `tipo_convenio`) VALUES
(10, 'Sede Principal Quibdó', 'Nacional', 'Docencia', 'Práctica'),
(11, 'Uribia', 'Internacional', 'Extensión', 'Institucional'),
(12, 'Barranquilla', '', 'Investigación', 'Organizacional'),
(13, 'Pereira', '', '', ''),
(14, 'Medellín', '', '', ''),
(15, 'Cali', '', '', ''),
(16, 'Neiva', '', '', ''),
(17, 'Sincelejo', '', '', ''),
(18, 'Bosconia', '', '', ''),
(19, 'Bogotá', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio`
--

CREATE TABLE `convenio` (
  `id_convenio` int(11) NOT NULL,
  `numero_convenio` int(11) NOT NULL,
  `nombre_institucion` varchar(100) DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  `caracteristica` varchar(100) DEFAULT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `cargar_pdf` varchar(100) DEFAULT NULL,
  `objeto_descripcion` varchar(500) DEFAULT NULL,
  `tipo_convenio` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `habilitado` int(11) NOT NULL,
  `correo_enviado` varchar(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `convenio`
--

INSERT INTO `convenio` (`id_convenio`, `numero_convenio`, `nombre_institucion`, `nacionalidad`, `caracteristica`, `fecha_inscripcion`, `fecha_expiracion`, `cargar_pdf`, `objeto_descripcion`, `tipo_convenio`, `id`, `id_estado`, `slug`, `habilitado`, `correo_enviado`) VALUES
(121, 1, 'Fundación Universitaria Claretiana 2023', 'Internacional', 'Investigación', '2020-07-07', '2023-08-27', '1693970796_Prueba PDF.pdf', 'Intercambiar servicios y desarrollar conjuntamente actividades docentes e investigativas en todos los campos de la Ciencia, con énfasis en lo social, lo antropológico, lo artístico, lo cultural y lo religioso, con el fin de contribuir al éxito del proyectos..', 'Práctica', 11, 3, 'fundaci-n-universitaria-claretiana-2023', 1, 'N'),
(122, 2, 'Universidad Tecnológica del Chocó', 'Nacional', 'Investigación', '2023-07-16', '2024-07-22', '1693970775_Prueba PDF.pdf', 'Segundo convenio Si quieres contactarte con los Centros de Atención Tutorial que tenemos para ti, selecciona tu ciudad más cercana:', 'Práctica', 12, 2, 'universidad-tecnol-gica-del-choc', 1, 'N'),
(123, 3, 'Universidad Nacional Abierta y a Distancia', 'Nacional', 'Docencia', '2023-07-21', '2011-07-06', '1693970761_Prueba PDF.pdf', 'Mejorar la educación de los estudiantes.', 'Institucional', 11, 3, 'universidad-nacional-abierta-y-a-distancia', 1, 'N'),
(124, 4, 'Politécnico Grancolombiano', 'Nacional', 'Investigación', '2020-07-28', '2017-06-06', '1693970870_Prueba PDF.pdf', 'En esta sección podrás actualizar un convenio existente diligenciando el siguiente formulario.', 'Organizacional', 12, 3, 'polit-cnico-grancolombiano', 1, 'N'),
(125, 5, 'SENA - Regional - Chocó', 'Nacional', 'Investigación', '2023-07-29', '2027-07-29', '1693970746_Prueba PDF.pdf', 'Si quieres contactarte con los Centros de Atención Tutorial que tenemos para ti, selecciona tu ciudad más cercana: Mejorar la educación de los estudiantes', 'Institucional', 13, 1, 'sena-regional-choc', 1, 'N'),
(126, 6, 'Alcaldía - Municipal de Quibdó', 'Nacional', 'Investigación', '2023-07-29', '2023-08-29', '1693970719_Prueba PDF.pdf', 'Mejorar la educación de los estudiantes', 'Organizacional', 13, 3, 'alcald-a-municipal-de-quibd', 1, 'N'),
(127, 7, 'Universidad de Antioquia', 'Nacional', 'Extensión', '2023-07-23', '2024-09-23', '1693970693_Prueba PDF.pdf', 'Mejorar la educación de los estudiantes', 'Institucional', 14, 1, 'universidad-de-antioquia', 1, 'N'),
(128, 8, 'Universidad del Valle del Cauca', 'Nacional', 'Investigación', '2023-08-07', '2022-11-07', '1693970682_Prueba PDF.pdf', 'Se entiende por convenio de cooperación interinstitucional a todo acto celebrado entre una institución y otras personas jurídicas de derecho público o privado, nacionales o extranjeras y cuya finalidad es aprovechar mutuamente sus recursos o fortalezas..', 'Institucional', 15, 3, 'universidad-del-valle-del-cauca', 1, 'N'),
(165, 9, 'Harvard University - Massachusetts', 'Internacional', 'Docencia', '2023-08-21', '2023-08-01', '1693970670_Prueba PDF.pdf', 'Promover el crecimiento espiritual de la comunidad académica como parte de su formación integral.', 'Institucional', 10, 3, 'harvard-university-massachusetts', 1, 'N'),
(211, 10, 'Alcaldía Municipal de Río Quito', 'Nacional', 'Investigación', '2023-08-01', '2025-11-13', '1693970656_Prueba PDF.pdf', 'En esta sección podrás registrar un nuevo convenio diligenciando el siguiente formulario.', 'Organizacional', 10, 1, 'alcald-a-municipal-de-r-o-quito', 1, 'N'),
(218, 11, 'Alcaldía Municipal de Yuto Atrato', 'Nacional', 'Docencia', '2023-08-01', '2026-11-18', '1693970648_Prueba PDF.pdf', 'En esta sección podrás actualizar un convenio existente diligenciando el siguiente formulario.', 'Práctica', 10, 1, 'alcald-a-municipal-de-yuto-atrato', 1, 'N'),
(219, 12, 'Alcaldía del Medio Atrato', 'Nacional', 'Investigación', '2023-08-02', '2026-12-29', '1693970637_Prueba PDF.pdf', 'En esta sección podrás actualizar un convenio existente diligenciando el siguiente formulario.', 'Institucional', 10, 1, 'alcald-a-del-medio-atrato', 1, 'N'),
(224, 13, 'Universidad de la Sabana', 'Nacional', 'Docencia', '2023-08-10', '2023-08-29', '1693970546_Prueba PDF.pdf', 'En esta sección podrás actualizar un convenio existente diligenciando el siguiente formulario.', 'Institucional', 11, 3, 'universidad-de-la-sabana', 1, 'N'),
(233, 14, 'Departamento del chocó ', 'Nacional', 'Docencia', '2023-09-14', '2023-09-20', '1693970618_Prueba PDF.pdf', 'En esta sección podrás actualizar un convenio existente diligenciando el siguiente formulario.', 'Institucional', 10, 2, 'departamento-del-choc', 1, 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_estados`
--

CREATE TABLE `convenio_estados` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `convenio_estados`
--

INSERT INTO `convenio_estados` (`id`, `name`) VALUES
(1, 'Vigente'),
(2, 'Próximo a vencer'),
(3, 'Vencido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_rol`
--

CREATE TABLE `permiso_rol` (
  `id_permiso` int(10) UNSIGNED NOT NULL,
  `id_roles` int(11) UNSIGNED NOT NULL,
  `url` varchar(100) NOT NULL,
  `create` tinyint(1) NOT NULL DEFAULT 0,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `update` tinyint(1) NOT NULL DEFAULT 0,
  `delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permiso_rol`
--

INSERT INTO `permiso_rol` (`id_permiso`, `id_roles`, `url`, `create`, `read`, `update`, `delete`) VALUES
(1, 1, 'gestio-usuarios', 1, 1, 1, 1),
(5, 1, 'detalle-convenio', 1, 1, 1, 1),
(6, 2, 'convenios', 0, 1, 0, 0),
(7, 2, 'gestion-redes', 1, 1, 1, 1),
(8, 2, 'detalle-convenio', 1, 1, 1, 1),
(11, 1, 'gestion-convenios', 1, 1, 1, 1),
(12, 1, 'gestion-redes', 1, 1, 1, 1),
(13, 1, 'conveios', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes`
--

CREATE TABLE `redes` (
  `id_redes` int(11) NOT NULL,
  `nombre_red` varchar(255) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `tipo_red` varchar(255) DEFAULT NULL,
  `caractistica_red` varchar(50) NOT NULL,
  `enlace` varchar(255) NOT NULL,
  `objeto` varchar(500) DEFAULT NULL,
  `id_convenio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `redes`
--

INSERT INTO `redes` (`id_redes`, `nombre_red`, `fecha_inscripcion`, `tipo_red`, `caractistica_red`, `enlace`, `objeto`, `id_convenio`) VALUES
(46, 'Fundación Universitaria Claretiana 2024', '2023-08-13', 'Extensión', 'Nacional', '     https://www.uniclaretiana.edu.co/', 'Fundación Universitaria Claretiana', 121),
(49, 'Fundación Universitaria Claretiana 2023', '2023-08-15', 'Administrativas', 'Internacional', '  https://www.uniclaretiana.edu.co/', 'En esta sección podrás actualizar una red diligenciando el siguiente formulario.', 121),
(52, 'Tratado interinstitucional del Chocó', '2023-08-27', 'Extensión', 'Nacional', ' https://www.uniclaretiana.edu.co/', ' En esta sección podrás registrar una nueva red diligenciando el siguiente formulario.', 121),
(53, 'Cátedra de la paz en Quibdó', '2023-08-27', 'Investigación', 'Nacional', ' https://www.uniclaretiana.edu.co/', ' En esta sección podrás registrar una nueva red diligenciando el siguiente formulario.', 121);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_roles` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_roles`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Auxiliar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id_sesion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id_sesion`, `id_usuario`, `token`, `fecha_creacion`, `fecha_expiracion`) VALUES
(621, 16, 'LY8cR4s44mz3bqZaWWuQxvlZZUDC5u6H', '2023-09-09 01:36:05', '2023-09-09 01:37:05'),
(622, 16, 'Lf3SuuTv1DOtX2y9uAcCW4w7RA2auxxW', '2023-09-09 02:01:33', '2023-09-09 02:02:33'),
(623, 16, 'CaRUICa4kJfrTJek0ToEmLNZFJ0Krxni', '2023-09-10 13:49:58', '2023-09-10 13:50:58'),
(624, 16, 'hGani0n7HIhdQGUIpuGlVOBJEo2sP7rD', '2023-09-10 13:53:32', '2023-09-10 13:54:32'),
(626, 16, 'jqwFjqvvWiAUfKqnd7yNrwa1154I4opY', '2023-09-10 14:06:41', '2023-09-10 14:07:41'),
(628, 16, 'lnirVg7ZkhP5qXtcjUdYDQnQw4QmSm63', '2023-09-10 14:33:24', '2023-09-10 14:34:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `alerta` int(11) NOT NULL,
  `id_contrasena` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `estado`, `contrasena`, `alerta`, `id_contrasena`) VALUES
(16, 'José Alirio Cabrera Palacios', 'jcabrera@miuniclaretiana.edu.co', 1, 'YVhIdGp0T1lzOC9iMFJ2S3dXcUp4QT09', 0, '72809ac3af59beeda0020f24fb93f50a'),
(103, 'Extensión Uniclaretiana', 'extension@uniclaretiana.edu.co', 1, 'YVhIdGp0T1lzOC9iMFJ2S3dXcUp4QT09', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_rol`
--

CREATE TABLE `usuarios_rol` (
  `id_usuarios_rol` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_roles` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_rol`
--

INSERT INTO `usuarios_rol` (`id_usuarios_rol`, `id_usuario`, `id_roles`) VALUES
(4, 16, 1),
(52, 103, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cat`
--
ALTER TABLE `cat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `convenio`
--
ALTER TABLE `convenio`
  ADD PRIMARY KEY (`id_convenio`),
  ADD UNIQUE KEY `numero_convenio` (`numero_convenio`),
  ADD UNIQUE KEY `id_convenio` (`id_convenio`),
  ADD KEY `convenio_ibfk_1` (`id`);

--
-- Indices de la tabla `convenio_estados`
--
ALTER TABLE `convenio_estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `id_roles` (`id_roles`);

--
-- Indices de la tabla `redes`
--
ALTER TABLE `redes`
  ADD PRIMARY KEY (`id_redes`),
  ADD KEY `FK_convenio` (`id_convenio`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `correo_2` (`correo`);

--
-- Indices de la tabla `usuarios_rol`
--
ALTER TABLE `usuarios_rol`
  ADD PRIMARY KEY (`id_usuarios_rol`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_roles` (`id_roles`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat`
--
ALTER TABLE `cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `convenio`
--
ALTER TABLE `convenio`
  MODIFY `id_convenio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT de la tabla `convenio_estados`
--
ALTER TABLE `convenio_estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  MODIFY `id_permiso` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `redes`
--
ALTER TABLE `redes`
  MODIFY `id_redes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_roles` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=629;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT de la tabla `usuarios_rol`
--
ALTER TABLE `usuarios_rol`
  MODIFY `id_usuarios_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `convenio`
--
ALTER TABLE `convenio`
  ADD CONSTRAINT `convenio_ibfk_1` FOREIGN KEY (`id`) REFERENCES `cat` (`id`);

--
-- Filtros para la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD CONSTRAINT `permiso_rol_ibfk_1` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `redes`
--
ALTER TABLE `redes`
  ADD CONSTRAINT `redes_ibfk_1` FOREIGN KEY (`id_convenio`) REFERENCES `convenio` (`id_convenio`) ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_rol`
--
ALTER TABLE `usuarios_rol`
  ADD CONSTRAINT `usuarios_rol_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_rol_ibfk_2` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
