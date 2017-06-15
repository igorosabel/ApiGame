-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-06-2017 a las 22:10:59
-- Versión del servidor: 5.5.55-0+deb8u1
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `game`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `background`
--

DROP TABLE IF EXISTS `background`;
CREATE TABLE `background` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada fondo',
  `id_category` int(11) NOT NULL COMMENT 'Id de la categoría a la que pertenece',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del fondo',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `crossable` int(1) NOT NULL DEFAULT '1' COMMENT 'Indica si la casilla se puede cruzar',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `background`
--

INSERT INTO `background` (`id`, `id_category`, `name`, `file`, `crossable`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hierba', 'grass', 1, '2017-03-04 00:00:00', '2017-03-13 21:21:35'),
(2, 1, 'Tierra', 'dirt', 1, '2017-03-04 00:00:00', '2017-03-14 18:47:07'),
(3, 2, 'Bosque', 'forest', 0, '2017-03-04 00:00:00', '2017-03-14 18:47:54'),
(4, 3, 'Agua no profunda', 'water-not-deep', 1, '2017-03-04 00:00:00', '2017-03-16 20:51:45'),
(6, 3, 'Agua profunda', 'water-deep', 0, '2017-03-05 00:00:00', '2017-03-16 20:52:43'),
(61, 3, 'Agua profunda sup', 'water-deep-up', 0, '2017-03-16 20:40:07', '2017-03-16 20:40:07'),
(62, 3, 'Agua profunda sup-der', 'water-deep-up-right', 0, '2017-03-16 20:40:39', '2017-03-16 20:40:39'),
(63, 3, 'Agua profunda der', 'water-deep-right', 0, '2017-03-16 20:41:07', '2017-03-16 20:41:07'),
(64, 3, 'Agua profunda inf-der', 'water-deep-down-right', 0, '2017-03-16 20:41:42', '2017-03-16 20:41:42'),
(65, 3, 'Agua profunda inf', 'water-deep-down', 0, '2017-03-16 20:42:07', '2017-03-16 20:42:07'),
(66, 3, 'Agua profunda inf-izq', 'water-deep-down-left', 0, '2017-03-16 20:42:33', '2017-03-16 20:42:33'),
(67, 3, 'Agua profunda izq', 'water-deep-left', 0, '2017-03-16 20:43:04', '2017-03-16 20:43:04'),
(68, 3, 'Agua profunda sup-izq', 'water-deep-up-left', 0, '2017-03-16 20:43:38', '2017-03-16 20:43:38'),
(69, 1, 'Desierto', 'desert', 1, '2017-03-16 21:14:21', '2017-03-16 21:14:21'),
(70, 4, 'Hierba montaña inf-izq', 'grass-mountain-down-left', 0, '2017-03-18 12:13:22', '2017-03-18 12:13:22'),
(71, 4, 'Hierba montaña inf', 'grass-mountain-down', 0, '2017-03-18 12:14:16', '2017-03-18 12:14:16'),
(72, 4, 'Hierba montaña inf-der', 'grass-mountain-down-right', 0, '2017-03-18 12:15:07', '2017-03-18 12:15:07'),
(73, 4, 'Hierba montaña inf-izq-izq', 'grass-mountain-down-left-left', 0, '2017-03-18 12:16:31', '2017-03-18 12:16:31'),
(74, 4, 'Hierba montaña izq', 'grass-mountain-left', 0, '2017-03-18 12:17:23', '2017-03-18 12:17:23'),
(75, 4, 'Hierba montaña inf-der-der', 'grass-mountain-down-right-right', 0, '2017-03-18 12:18:24', '2017-03-18 12:18:24'),
(76, 4, 'Hierba montaña der', 'grass-mountain-right', 0, '2017-03-18 12:19:40', '2017-03-18 12:19:40'),
(77, 4, 'Hierba montaña sup-izq', 'grass-mountain-up-left', 0, '2017-03-18 12:20:40', '2017-03-18 12:20:40'),
(78, 4, 'Hierba montaña sup-der', 'grass-mountain-up-right', 0, '2017-03-18 12:21:43', '2017-03-18 12:21:43'),
(79, 4, 'Hierba montaña sup', 'grass-mountain-up', 0, '2017-03-18 12:22:32', '2017-03-18 12:22:32'),
(80, 4, 'Hierba montaña sup-izq-sup', 'grass-mountain-up-left-up', 0, '2017-03-18 12:24:18', '2017-03-18 12:24:18'),
(81, 4, 'Hierba montaña sup-der-sup', 'grass-mountain-up-right-up', 0, '2017-03-18 12:25:39', '2017-03-18 12:25:39'),
(82, 4, 'Montaña inf-1', 'mountain-down-1', 0, '2017-03-18 12:27:19', '2017-03-18 12:27:19'),
(83, 4, 'Montaña inf-2', 'mountain-down-2', 0, '2017-03-18 12:29:08', '2017-03-18 12:29:08'),
(84, 4, 'Montaña inf-izq-1', 'mountain-down-left-1', 0, '2017-03-18 12:30:15', '2017-03-18 12:30:15'),
(85, 4, 'Montaña inf-izq-2', 'mountain-down-left-2', 0, '2017-03-18 12:32:36', '2017-03-18 12:32:36'),
(86, 4, 'Montaña inf-izq-izq', 'mountain-down-left-left', 0, '2017-03-18 12:33:40', '2017-03-18 12:33:40'),
(87, 4, 'Montaña inf-der-1', 'mountain-down-right-1', 0, '2017-03-18 12:35:17', '2017-03-18 12:35:17'),
(88, 4, 'Montaña inf-der-2', 'mountain-down-right-2', 0, '2017-03-18 12:36:26', '2017-03-18 12:36:26'),
(89, 4, 'Montaña inf-der-der', 'mountain-down-right-right', 0, '2017-03-18 12:37:26', '2017-03-18 12:37:26'),
(90, 4, 'Montaña izq', 'mountain-left', 0, '2017-03-18 12:40:15', '2017-03-18 12:40:15'),
(91, 4, 'Montaña der', 'mountain-right', 0, '2017-03-18 12:41:24', '2017-03-18 12:41:24'),
(92, 4, 'Montaña sup-izq', 'mountain-up-left', 0, '2017-03-18 12:43:43', '2017-03-18 12:43:43'),
(93, 4, 'Montaña sup-der', 'mountain-up-right', 0, '2017-03-18 12:44:34', '2017-03-18 12:44:34'),
(94, 4, 'Cumbre sup', 'mountain-top-up', 1, '2017-03-18 12:59:39', '2017-03-18 12:59:39'),
(95, 4, 'Cumbre sup-izq', 'mountain-top-up-left', 1, '2017-03-18 13:00:59', '2017-03-18 13:00:59'),
(96, 4, 'Cumbre conector sup-izq', 'mountain-top-up-left-connector', 1, '2017-03-18 13:02:36', '2017-03-18 13:02:36'),
(97, 4, 'Cumbre izq', 'mountain-top-left', 1, '2017-03-18 13:03:14', '2017-03-18 13:03:14'),
(98, 4, 'Cumbre conector inf-izq', 'mountain-top-down-left-connector', 1, '2017-03-18 13:04:13', '2017-03-18 13:04:13'),
(99, 4, 'Cumbre inf-izq', 'mountain-top-down-left', 1, '2017-03-18 13:04:54', '2017-03-18 13:04:54'),
(100, 4, 'Cumbre inf', 'mountain-top-down', 1, '2017-03-18 13:05:22', '2017-03-18 13:05:22'),
(101, 4, 'Cumbre inf-der', 'mountain-top-down-right', 1, '2017-03-18 13:05:56', '2017-03-18 13:05:56'),
(102, 4, 'Cumbre conector inf-der', 'mountain-top-down-right-connector', 1, '2017-03-18 13:06:41', '2017-03-18 13:06:41'),
(103, 4, 'Cumbre der', 'mountain-top-right', 1, '2017-03-18 13:07:21', '2017-03-18 13:07:21'),
(104, 4, 'Cumbre conector sup-der', 'mountain-top-up-right-connector', 1, '2017-03-18 13:08:23', '2017-03-18 13:08:23'),
(105, 4, 'Cumbre sup-der', 'mountain-top-up-right', 1, '2017-03-18 13:09:13', '2017-03-18 13:09:13'),
(106, 4, 'Cumbre roca 1', 'mountain-top-rock-1', 1, '2017-03-18 13:13:15', '2017-03-18 13:13:15'),
(107, 4, 'Cumbre roca 2', 'mountain-top-rock-2', 1, '2017-03-18 13:13:33', '2017-03-18 13:13:33'),
(108, 4, 'Cumbre roca 3', 'mountain-top-rock-3', 1, '2017-03-18 13:14:03', '2017-03-18 13:14:03'),
(109, 4, 'Montaña conector inf-sup-izq-1', 'mountain-down-top-left-connector-1', 0, '2017-03-18 13:54:43', '2017-03-18 13:54:43'),
(110, 4, 'Montaña conector inf-sup-izq-2', 'mountain-down-top-left-connector-2', 0, '2017-03-18 13:55:58', '2017-03-18 13:55:58'),
(111, 4, 'Montaña conector inf-sup-der-1', 'mountain-down-top-right-connector-1', 0, '2017-03-18 13:56:41', '2017-03-18 13:56:41'),
(112, 4, 'Montaña conector inf-sup-der-2', 'mountain-down-top-right-connector-2', 0, '2017-03-18 13:57:53', '2017-03-18 13:57:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `background_category`
--

DROP TABLE IF EXISTS `background_category`;
CREATE TABLE `background_category` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Slug del nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `background_category`
--

INSERT INTO `background_category` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Suelo', 'suelo', '2017-03-05 00:00:00', NULL),
(2, 'Árboles', 'arboles', '2017-03-05 00:00:00', NULL),
(3, 'Agua', 'agua', '2017-03-05 00:00:00', NULL),
(4, 'Montaña', 'montana', '2017-03-05 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character`
--

DROP TABLE IF EXISTS `character`;
CREATE TABLE `character` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada tipo de personaje',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del tipo de personaje',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Slug del nombre del tipo de personaje',
  `file_up` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia arriba',
  `file_down` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia abajo',
  `file_left` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia la izquierda',
  `file_right` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia la derecha',
  `is_npc` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el tipo de personaje es un NPC',
  `is_enemy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el tipo de personaje es un enemigo',
  `health` int(11) NOT NULL DEFAULT '3' COMMENT 'Salud del tipo de personaje',
  `attack` int(11) NOT NULL DEFAULT '1' COMMENT 'Daño que hace el tipo de personaje',
  `speed` int(11) NOT NULL DEFAULT '1' COMMENT 'Velocidad el tipo de personaje',
  `drops` int(11) DEFAULT NULL COMMENT 'Id del elemento que da el tipo de personaje',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `character_frame`
--

DROP TABLE IF EXISTS `character_frame`;
CREATE TABLE `character_frame` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada frame del tipo de personaje',
  `id_character` int(11) NOT NULL COMMENT 'Id del tipo de personaje al que pertenece el frame',
  `orientation` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Orientación de la imagen del frame',
  `order` int(11) NOT NULL DEFAULT '1' COMMENT 'Orden del frame en la animación',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `connection`
--

DROP TABLE IF EXISTS `connection`;
CREATE TABLE `connection` (
  `id_from` int(11) NOT NULL COMMENT 'Id de la categoría en la que está el producto',
  `id_to` int(11) NOT NULL COMMENT 'Id del producto',
  `direction` int(11) NOT NULL COMMENT 'Id del producto',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE `game` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada partida',
  `id_user` int(11) NOT NULL COMMENT 'Id del usuario al que pertenece la partida',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre del personaje',
  `id_scenario` int(11) DEFAULT NULL COMMENT 'Id del escenario en el que está el usuario',
  `position_x` int(11) DEFAULT NULL COMMENT 'Última posición X guardada del jugador',
  `position_y` int(11) DEFAULT NULL COMMENT 'Última posición Y guardada del jugador',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT 'Cantidad de dinero que tiene el jugador',
  `health` int(11) NOT NULL DEFAULT '3' COMMENT 'Salud actual del jugador',
  `max_health` int(11) NOT NULL DEFAULT '3' COMMENT 'Máxima salud del jugador',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `game`
--

INSERT INTO `game` (`id`, `id_user`, `name`, `id_scenario`, `position_x`, `position_y`, `money`, `health`, `max_health`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dunedain', 1, 14, 13, 0, 3, 3, '2017-03-05 23:12:31', '2017-03-07 20:17:36'),
(2, 1, NULL, NULL, NULL, NULL, 0, 3, 3, '2017-03-05 23:12:31', '2017-03-05 23:12:31'),
(3, 1, NULL, NULL, NULL, NULL, 0, 3, 3, '2017-03-05 23:12:31', '2017-03-05 23:12:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interactive`
--

DROP TABLE IF EXISTS `interactive`;
CREATE TABLE `interactive` (
  `id` int(11) NOT NULL COMMENT 'Id del elemento interactivo',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del elemento',
  `type` int(11) NOT NULL COMMENT 'Tipo del elemento',
  `activable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el elemento se puede activar',
  `pickable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el elemento se puede coger al inventario',
  `grabbable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el elemento se puede coger',
  `breakable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el elemento se puede romper',
  `crossable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el elemento se puede cruzar',
  `crossable_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el elemento se puede cruzar una vez activao',
  `sprite_start` int(11) NOT NULL COMMENT 'Sprite inicial del elemento',
  `sprite_active` int(11) DEFAULT NULL COMMENT 'Sprite del elemento al activar',
  `drops` int(11) DEFAULT NULL COMMENT 'Id del elemento que se obtiene al activar o romperlo',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT 'Número de elementos que se obtienen al activar o romper',
  `active_time` int(11) NOT NULL DEFAULT '0' COMMENT 'Número de segundos que se mantiene activo, 0 ilimitado',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `interactive`
--

INSERT INTO `interactive` (`id`, `name`, `type`, `activable`, `pickable`, `grabbable`, `breakable`, `crossable`, `crossable_active`, `sprite_start`, `sprite_active`, `drops`, `quantity`, `active_time`, `created_at`, `updated_at`) VALUES
(1, 'Cofre', 0, 0, 0, 0, 0, 0, 0, 47, 48, 0, 0, 0, '2017-06-02 19:21:18', '2017-06-02 20:29:02'),
(5, 'Cofre grande', 4, 1, 0, 0, 0, 0, 0, 84, 85, 0, 0, 0, '2017-06-02 21:47:44', '2017-06-11 13:11:34'),
(6, 'Arbusto', 4, 0, 0, 1, 1, 0, 1, 1, 91, 0, 0, 0, '2017-06-13 20:50:53', '2017-06-13 20:50:53'),
(7, 'Moneda (verde)', 2, 0, 1, 0, 0, 0, 0, 87, 0, 0, 1, 0, '2017-06-13 21:00:41', '2017-06-13 21:01:04'),
(8, 'Moneda (roja)', 2, 0, 1, 0, 0, 0, 0, 89, 0, 0, 5, 0, '2017-06-13 21:01:31', '2017-06-13 21:01:31'),
(9, 'Moneda (Azul)', 2, 0, 1, 0, 0, 0, 0, 88, 0, 0, 10, 0, '2017-06-13 21:02:04', '2017-06-13 21:02:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL COMMENT 'Id único del elemento del inventario',
  `id_game` int(11) NOT NULL COMMENT 'Id de la partida en la que está el elemento',
  `id_item` int(11) NOT NULL COMMENT 'Id del elemento',
  `order` int(11) NOT NULL COMMENT 'Orden del elemento en el inventario',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT 'Cantidad del item en el inventario',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scenario`
--

DROP TABLE IF EXISTS `scenario`;
CREATE TABLE `scenario` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada escenario',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del escenario',
  `data` text COLLATE utf8_unicode_ci COMMENT 'Datos que componen el escenario',
  `start_x` int(11) DEFAULT NULL COMMENT 'Indica la casilla X de la que se sale',
  `start_y` int(11) DEFAULT NULL COMMENT 'Indica la casilla Y de la que se sale',
  `initial` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si es el escenario inicial 1 o no 0',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `scenario`
--

INSERT INTO `scenario` (`id`, `name`, `data`, `start_x`, `start_y`, `initial`, `created_at`, `updated_at`) VALUES
(1, 'Inicio', '[[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\",\"spr\":\"65\"},{\"bck\":\"1\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":\"17\"},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":\"18\"},{\"bck\":\"2\",\"spr\":\"59\"},{\"bck\":\"2\",\"spr\":\"55\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\",\"spr\":\"58\"},{\"bck\":\"2\",\"spr\":\"65\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\",\"spr\":\"82\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":19},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":\"20\"},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\",\"spr\":\"63\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":9},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":19},{\"bck\":1,\"spr\":\"20\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\",\"spr\":\"63\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":1},{\"bck\":1},{\"bck\":1,\"spr\":2},{\"bck\":1,\"spr\":2},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":6},{\"bck\":\"2\",\"spr\":\"59\"},{\"bck\":\"2\",\"spr\":\"55\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\",\"spr\":\"58\"},{\"bck\":\"2\",\"spr\":\"65\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"4\",\"spr\":\"64\"},{\"bck\":\"4\",\"spr\":\"66\"},{\"bck\":\"4\",\"spr\":\"66\"},{\"bck\":\"4\",\"spr\":\"66\"},{\"bck\":\"4\",\"spr\":\"66\"},{\"bck\":\"4\",\"spr\":\"66\"},{\"bck\":\"4\",\"spr\":\"66\"},{\"bck\":\"4\",\"spr\":\"66\"},{\"bck\":\"4\",\"spr\":\"65\"},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\",\"spr\":\"58\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":4},{\"bck\":4},{\"bck\":4,\"spr\":24},{\"bck\":4},{\"bck\":4},{\"bck\":\"4\",\"spr\":\"22\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":\"2\",\"spr\":\"59\"},{\"bck\":\"2\",\"spr\":\"55\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"66\"},{\"bck\":\"2\",\"spr\":\"65\"},{\"bck\":1},{\"bck\":\"4\",\"spr\":\"64\"},{\"bck\":\"4\",\"spr\":\"57\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"56\"},{\"bck\":\"4\",\"spr\":\"61\"},{\"bck\":\"4\",\"spr\":\"61\"},{\"bck\":\"4\",\"spr\":\"61\"},{\"bck\":\"4\",\"spr\":\"55\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"58\"},{\"bck\":\"4\",\"spr\":\"65\"},{\"bck\":\"2\",\"spr\":\"59\"},{\"bck\":\"2\",\"spr\":\"55\"},{\"bck\":2},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"57\"},{\"bck\":2,\"spr\":8},{\"bck\":\"2\",\"spr\":\"63\"},{\"bck\":1},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":4,\"spr\":\"22\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":\"1\"},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":\"4\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"57\"},{\"bck\":2,\"spr\":7},{\"bck\":2},{\"bck\":\"2\",\"spr\":\"63\"},{\"bck\":1},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":4},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":\"1\"},{\"bck\":\"1\",\"spr\":\"47\"},{\"bck\":\"1\"},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"22\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2},{\"bck\":2,\"spr\":14}],[{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2},{\"bck\":2},{\"bck\":2},{\"bck\":\"2\",\"spr\":\"63\"},{\"bck\":1,\"spr\":4},{\"bck\":\"4\",\"spr\":\"59\"},{\"bck\":\"4\",\"spr\":\"55\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"1\"},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"56\"},{\"bck\":\"4\",\"spr\":\"60\"},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2,\"spr\":14},{\"bck\":2,\"spr\":14}],[{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"59\"},{\"bck\":\"2\",\"spr\":\"61\"},{\"bck\":\"2\",\"spr\":\"55\"},{\"bck\":2},{\"bck\":\"2\",\"spr\":\"63\"},{\"bck\":1,\"spr\":3},{\"bck\":1,\"spr\":3},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":\"4\",\"spr\":\"23\"},{\"bck\":\"4\",\"spr\":\"58\"},{\"bck\":\"4\",\"spr\":\"65\"},{\"bck\":\"1\"},{\"bck\":\"4\",\"spr\":\"64\"},{\"bck\":\"4\",\"spr\":\"57\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2,\"spr\":14},{\"bck\":2,\"spr\":14}],[{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"59\"},{\"bck\":\"2\",\"spr\":\"61\"},{\"bck\":\"2\",\"spr\":\"60\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"4\",\"spr\":\"59\"},{\"bck\":\"4\",\"spr\":\"55\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"63\"},{\"bck\":\"1\"},{\"bck\":\"4\",\"spr\":\"62\"},{\"bck\":\"4\",\"spr\":\"23\"},{\"bck\":\"4\",\"spr\":\"56\"},{\"bck\":\"4\",\"spr\":\"60\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"62\"},{\"bck\":2},{\"bck\":2,\"spr\":14}],[{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":\"11\"},{\"bck\":\"4\",\"spr\":\"59\"},{\"bck\":\"4\",\"spr\":\"61\"},{\"bck\":\"4\",\"spr\":\"60\"},{\"bck\":\"1\"},{\"bck\":\"4\",\"spr\":\"59\"},{\"bck\":\"4\",\"spr\":\"61\"},{\"bck\":\"4\",\"spr\":\"60\"},{\"bck\":1,\"spr\":\"11\"},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"57\"},{\"bck\":2},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"13\"},{\"bck\":\"1\",\"spr\":\"27\"},{\"bck\":1},{\"bck\":1,\"spr\":\"27\"},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"13\"},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"57\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\",\"spr\":\"78\"},{\"bck\":\"1\",\"spr\":\"80\"},{\"bck\":\"1\",\"spr\":\"80\"},{\"bck\":\"1\",\"spr\":\"79\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"57\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\",\"spr\":\"76\"},{\"bck\":\"1\",\"spr\":\"67\"},{\"bck\":\"1\",\"spr\":\"68\"},{\"bck\":\"1\",\"spr\":\"77\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1,\"spr\":\"81\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"57\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\",\"spr\":\"73\"},{\"bck\":\"1\",\"spr\":\"75\"},{\"bck\":\"1\",\"spr\":\"75\"},{\"bck\":\"1\",\"spr\":\"74\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"2\",\"spr\":\"64\"},{\"bck\":\"2\",\"spr\":\"57\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}]]', 15, 14, 0, '2017-03-04 13:10:01', '2017-05-31 20:47:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sprite`
--

DROP TABLE IF EXISTS `sprite`;
CREATE TABLE `sprite` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada fondo',
  `id_category` int(11) NOT NULL COMMENT 'Id de la categoría a la que pertenece',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del fondo',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `crossable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si la casilla se puede cruzar 1 o no 0',
  `width` int(11) NOT NULL DEFAULT '1' COMMENT 'Anchura del sprite en casillas',
  `height` int(11) NOT NULL DEFAULT '1' COMMENT 'Altura del sprite en casillas',
  `frames` int(11) NOT NULL DEFAULT '0' COMMENT 'Número de frames para animar el sprite',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sprite`
--

INSERT INTO `sprite` (`id`, `id_category`, `name`, `file`, `crossable`, `width`, `height`, `frames`, `created_at`, `updated_at`) VALUES
(1, 1, 'Arbusto', 'bush', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-05-30 21:20:36'),
(2, 2, 'Roca', 'stone', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-14 20:05:13'),
(3, 1, 'Hierba', 'grass-no-flower', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:42:55'),
(4, 1, 'Hierba flor', 'grass-flower', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:34'),
(5, 1, 'Hierba flores', 'grass-flowers', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:39'),
(6, 3, 'Cartel', 'signal', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:45:03'),
(7, 1, 'Arbusto seco', 'bush-dry', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:42:40'),
(8, 1, 'Hierba seca', 'grass-dry', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:49'),
(9, 2, 'Piedra pesada', 'stone-heavy', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:39:14'),
(10, 3, 'Valla doble', 'fence-doble', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:17'),
(11, 3, 'Valla abajo', 'fence-down', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:08'),
(12, 3, 'Valla derecha', 'fence-right', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:12'),
(13, 3, 'Valla simple', 'fence-simple', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:24'),
(14, 3, 'Baldosa', 'tile', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:44:57'),
(15, 1, 'Hierba más', 'grass-more', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:44'),
(16, 1, 'Hierba alta', 'tall-grass', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:02'),
(17, 1, 'Hierba alta sup-izq', 'tall-grass-up-left', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:30'),
(18, 1, 'Hierba alta sup-der', 'tall-grass-up-right', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:25'),
(19, 1, 'Hierba alta inf-izq', 'tall-grass-down-left', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:19'),
(20, 1, 'Hierba alta inf-der', 'tall-grass-down-right', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:08'),
(21, 3, 'Poste', 'post', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:03'),
(22, 4, 'Ola', 'water-wave', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:41:00'),
(23, 4, 'Onda', 'water-ripple', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:41:05'),
(24, 4, 'Burbujas 1', 'water-bubbles-1', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:40:50'),
(25, 4, 'Burbujas 2', 'water-bubbles-2', 1, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:40:55'),
(26, 4, 'Piedra', 'stone-water', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-06-04 21:35:00'),
(27, 3, 'Valla piedra', 'fence-stone', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:21'),
(46, 3, 'Jarrón', 'jar', 0, 1, 1, 0, '2017-03-20 00:01:53', '2017-03-22 23:45:58'),
(47, 3, 'Cofre', 'chest', 0, 1, 1, 0, '2017-03-20 00:06:05', '2017-03-22 23:45:08'),
(48, 3, 'Cofre abierto', 'chest-open', 0, 1, 1, 0, '2017-03-20 00:06:38', '2017-03-22 23:45:12'),
(55, 1, 'Hierba sobre conector inf-izq', 'grass-over-connect-down-left', 1, 1, 1, 0, '2017-03-24 22:12:43', '2017-03-24 22:12:43'),
(56, 1, 'Hierba sobre conector inf-der', 'grass-over-connect-down-right', 1, 1, 1, 0, '2017-03-24 22:13:54', '2017-03-24 22:13:54'),
(57, 1, 'Hierba sobre conector sup-izq', 'grass-over-connect-up-left', 1, 1, 1, 0, '2017-03-24 22:14:23', '2017-03-24 22:14:23'),
(58, 1, 'Hierba sobre conector sup-der', 'grass-over-connect-up-right', 1, 1, 1, 0, '2017-03-24 22:14:56', '2017-03-24 22:14:56'),
(59, 1, 'Hierba sobre inf-izq', 'grass-over-down-left', 1, 1, 1, 0, '2017-03-24 22:15:24', '2017-03-24 22:15:24'),
(60, 1, 'Hierba sobre inf-der', 'grass-over-down-right', 1, 1, 1, 0, '2017-03-24 22:20:17', '2017-03-24 22:20:17'),
(61, 1, 'Hierba sobre inf', 'grass-over-down', 1, 1, 1, 0, '2017-03-24 22:20:55', '2017-03-24 22:20:55'),
(62, 1, 'Hierba sobre izq', 'grass-over-left', 1, 1, 1, 0, '2017-03-24 22:21:19', '2017-03-24 22:21:19'),
(63, 1, 'Hierba sobre der', 'grass-over-right', 1, 1, 1, 0, '2017-03-24 22:22:31', '2017-03-24 22:22:31'),
(64, 1, 'Hierba sobre sup-izq', 'grass-over-up-left', 1, 1, 1, 0, '2017-03-24 22:22:53', '2017-03-24 22:22:53'),
(65, 1, 'Hierba sobre sup-der', 'grass-over-up-right', 1, 1, 1, 0, '2017-03-24 22:23:22', '2017-03-24 22:23:22'),
(66, 1, 'Hierba sobre sup', 'grass-over-up', 1, 1, 1, 0, '2017-03-24 22:23:52', '2017-03-24 22:23:52'),
(67, 2, 'Roca burbuja', 'rock-bubble', 0, 1, 1, 0, '2017-03-24 23:14:44', '2017-03-24 23:14:44'),
(68, 2, 'Roca centro', 'rock-center', 0, 1, 1, 0, '2017-03-24 23:15:02', '2017-03-24 23:15:02'),
(69, 2, 'Roca conector inf-izq', 'rock-connect-down-left', 0, 1, 1, 0, '2017-03-24 23:15:33', '2017-03-24 23:15:33'),
(70, 2, 'Roca conector inf-der', 'rock-connect-down-right', 0, 1, 1, 0, '2017-03-24 23:17:27', '2017-03-24 23:17:27'),
(71, 2, 'Roca conector sup-izq', 'rock-connect-up-left', 0, 1, 1, 0, '2017-03-24 23:17:54', '2017-03-24 23:17:54'),
(72, 2, 'Roca conector sup-der', 'rock-connect-up-right', 0, 1, 1, 0, '2017-03-24 23:18:20', '2017-03-24 23:18:20'),
(73, 2, 'Roca inf-izq', 'rock-down-left', 0, 1, 1, 0, '2017-03-24 23:18:45', '2017-03-24 23:18:45'),
(74, 2, 'Roca inf-der', 'rock-down-right', 0, 1, 1, 0, '2017-03-24 23:19:05', '2017-03-24 23:19:05'),
(75, 2, 'Roca inf', 'rock-down', 0, 1, 1, 0, '2017-03-24 23:19:28', '2017-03-24 23:19:28'),
(76, 2, 'Roca izq', 'rock-left', 0, 1, 1, 0, '2017-03-24 23:20:02', '2017-03-24 23:20:02'),
(77, 2, 'Roca der', 'rock-right', 0, 1, 1, 0, '2017-03-24 23:20:33', '2017-03-24 23:20:33'),
(78, 2, 'Roca sup-izq', 'rock-up-left', 0, 1, 1, 0, '2017-03-24 23:21:02', '2017-03-24 23:21:02'),
(79, 2, 'Roca sup-der', 'rock-up-right', 0, 1, 1, 0, '2017-03-24 23:21:15', '2017-03-24 23:21:15'),
(80, 2, 'Roca sup', 'rock-up', 0, 1, 1, 0, '2017-03-24 23:21:26', '2017-03-24 23:21:26'),
(81, 1, 'Árbol cortado', 'tree-cut', 0, 2, 2, 0, '2017-05-30 21:25:47', '2017-05-30 21:25:47'),
(82, 3, 'Estatua', 'statue', 0, 2, 3, 0, '2017-05-31 20:19:07', '2017-05-31 20:19:07'),
(83, 2, 'Roca grande', 'big-stone', 0, 2, 2, 0, '2017-05-31 20:23:07', '2017-05-31 20:23:07'),
(84, 3, 'Cofre grande', 'big-chest', 0, 3, 2, 0, '2017-06-02 20:33:50', '2017-06-02 20:33:50'),
(85, 3, 'Cofre grande abierto', 'big-chest-open', 0, 3, 2, 0, '2017-06-02 20:35:19', '2017-06-02 20:35:19'),
(87, 3, 'Moneda (verde)', 'coin-green', 0, 1, 1, 2, '2017-06-08 20:31:28', '2017-06-10 11:39:29'),
(88, 3, 'Moneda (azul)', 'coin-blue', 0, 1, 1, 2, '2017-06-10 11:43:16', '2017-06-10 11:43:16'),
(89, 3, 'Moneda (roja)', 'coin-red', 0, 1, 1, 2, '2017-06-10 11:43:41', '2017-06-10 11:43:41'),
(90, 1, 'Cactus', 'cactus', 0, 1, 2, 0, '2017-06-12 20:19:47', '2017-06-12 20:19:47'),
(91, 1, 'Arbusto cortado', 'green-bush-cut', 1, 1, 1, 0, '2017-06-13 20:45:57', '2017-06-13 20:45:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sprite_category`
--

DROP TABLE IF EXISTS `sprite_category`;
CREATE TABLE `sprite_category` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Slug del nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sprite_category`
--

INSERT INTO `sprite_category` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Arbustos', 'arbustos', '2017-03-05 00:00:00', NULL),
(2, 'Rocas', 'rocas', '2017-03-05 00:00:00', NULL),
(3, 'Objetos', 'objetos', '2017-03-05 00:00:00', NULL),
(4, 'Agua', 'agua', '2017-03-05 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sprite_frame`
--

DROP TABLE IF EXISTS `sprite_frame`;
CREATE TABLE `sprite_frame` (
  `id` int(11) NOT NULL COMMENT 'Id único del frame',
  `id_sprite` int(11) NOT NULL COMMENT 'Id del sprite al que pertenece el frame',
  `order` int(11) NOT NULL DEFAULT '1' COMMENT 'Orden del frame en la animación',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sprite_frame`
--

INSERT INTO `sprite_frame` (`id`, `id_sprite`, `order`, `file`, `created_at`, `updated_at`) VALUES
(3, 87, 1, 'coin-green-1', '2017-06-10 11:39:29', '2017-06-10 11:39:29'),
(4, 87, 2, 'coin-green-2', '2017-06-10 11:39:29', '2017-06-10 11:39:29'),
(5, 88, 1, 'coin-blue-1', '2017-06-10 11:43:16', '2017-06-10 11:43:16'),
(6, 88, 2, 'coin-blue-2', '2017-06-10 11:43:16', '2017-06-10 11:43:16'),
(7, 89, 1, 'coin-red-1', '2017-06-10 11:43:41', '2017-06-10 11:43:41'),
(8, 89, 2, 'coin-red-2', '2017-06-10 11:43:41', '2017-06-10 11:43:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada usuario',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email del usuario',
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contraseña del usuario',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `pass`, `created_at`, `updated_at`) VALUES
(1, 'inigo.gorosabel@gmail.com', 'f0226729dbb313d0fea448947431c0da897c23a0', '2017-03-05 23:12:31', '2017-03-05 23:12:31');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `background`
--
ALTER TABLE `background`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `background_category`
--
ALTER TABLE `background_category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `character`
--
ALTER TABLE `character`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `character_frame`
--
ALTER TABLE `character_frame`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `connection`
--
ALTER TABLE `connection`
  ADD PRIMARY KEY (`id_from`,`id_to`);

--
-- Indices de la tabla `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `interactive`
--
ALTER TABLE `interactive`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `scenario`
--
ALTER TABLE `scenario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sprite`
--
ALTER TABLE `sprite`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sprite_category`
--
ALTER TABLE `sprite_category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sprite_frame`
--
ALTER TABLE `sprite_frame`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `background`
--
ALTER TABLE `background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo', AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT de la tabla `background_category`
--
ALTER TABLE `background_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `character`
--
ALTER TABLE `character`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada tipo de personaje';
--
-- AUTO_INCREMENT de la tabla `character_frame`
--
ALTER TABLE `character_frame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada frame del tipo de personaje';
--
-- AUTO_INCREMENT de la tabla `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada partida', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `interactive`
--
ALTER TABLE `interactive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id del elemento interactivo', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único del elemento del inventario';
--
-- AUTO_INCREMENT de la tabla `scenario`
--
ALTER TABLE `scenario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada escenario', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sprite`
--
ALTER TABLE `sprite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo', AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT de la tabla `sprite_category`
--
ALTER TABLE `sprite_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `sprite_frame`
--
ALTER TABLE `sprite_frame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único del frame', AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada usuario', AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
