-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-03-2017 a las 21:17:14
-- Versión del servidor: 5.5.54-0+deb8u1
-- Versión de PHP: 5.6.14

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
  `class` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la clase',
  `css` text COLLATE utf8_unicode_ci COMMENT 'CSS de la clase',
  `crossable` int(1) NOT NULL DEFAULT '1' COMMENT 'Indica si la casilla se puede cruzar',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `background`
--

INSERT INTO `background` (`id`, `id_category`, `name`, `class`, `css`, `crossable`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hierba', 'grass', 'background-color: #00994c;', 1, '2017-03-04 00:00:00', '2017-03-13 21:21:35'),
(2, 1, 'Tierra', 'dirt', 'background: url(\'/assets/background/dirt.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-04 00:00:00', '2017-03-14 18:47:07'),
(3, 2, 'Bosque', 'forest', 'background-color: #1fad62;', 0, '2017-03-04 00:00:00', '2017-03-14 18:47:54'),
(4, 3, 'Agua no profunda', 'water-not-deep', 'background-color: #3f82be;', 1, '2017-03-04 00:00:00', '2017-03-16 20:51:45'),
(5, 4, 'Roca', 'rock', 'background-color: #888;', 0, '2017-03-04 00:00:00', '2017-03-14 18:50:23'),
(6, 3, 'Agua profunda', 'water-deep', 'background-color: #0f61a6;', 0, '2017-03-05 00:00:00', '2017-03-16 20:52:43'),
(24, 3, 'Agua hierba sup-izq', 'grass-water-up-left', 'background: url(\'/assets/background/grass-water-up-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-12 19:27:18', '2017-03-14 18:48:46'),
(25, 3, 'Agua hierba conector sup-izq', 'grass-water-connect-up-left', 'background: url(\'/assets/background/grass-water-up-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-12 19:35:15', '2017-03-14 20:30:54'),
(26, 3, 'Agua hierba sup', 'grass-water-up', 'background: url(\'/assets/background/grass-water-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-12 19:38:27', '2017-03-14 18:49:13'),
(27, 3, 'Agua hierba sup-der', 'grass-water-up-right', 'background: url(\'/assets/background/grass-water-up-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-12 19:41:49', '2017-03-14 18:49:30'),
(28, 3, 'Agua hierba der', 'grass-water-right', 'background: url(\'/assets/background/grass-water-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-12 19:43:56', '2017-03-14 18:49:44'),
(29, 3, 'Agua hierba izq', 'grass-water-left', 'background: url(\'/assets/background/grass-water-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-12 19:46:16', '2017-03-14 18:49:54'),
(30, 3, 'Agua hierba conector sup-der', 'grass-water-connect-up-right', 'background: url(\'/assets/background/grass-water-up-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:33:00', '2017-03-14 20:33:00'),
(31, 3, 'Agua hierba inf-der', 'grass-water-down-right', 'background: url(\'/assets/background/grass-water-down-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:35:19', '2017-03-14 20:35:19'),
(32, 3, 'Agua hierba inf-izq', 'grass-water-down-left', 'background: url(\'/assets/background/grass-water-down-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:36:00', '2017-03-14 20:36:00'),
(33, 3, 'Agua hierba conector inf-izq', 'grass-water-connect-down-left', 'background: url(\'/assets/background/grass-water-down-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:37:28', '2017-03-14 20:37:28'),
(34, 3, 'Agua hierba conector inf-der', 'grass-water-connect-down-right', 'background: url(\'/assets/background/grass-water-down-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:38:07', '2017-03-14 20:38:07'),
(35, 3, 'Agua hierba inf', 'grass-water-down', 'background: url(\'/assets/background/grass-water-down.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:41:03', '2017-03-14 20:41:03'),
(36, 1, 'Hierba tierra sup', 'grass-dirt-up', 'background: url(\'/assets/background/grass-dirt-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:57:01', '2017-03-14 20:57:36'),
(37, 1, 'Hierba tierra inf', 'grass-dirt-down', 'background: url(\'/assets/background/grass-dirt-down.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:58:10', '2017-03-14 20:58:10'),
(38, 1, 'Hierba tierra izq', 'grass-dirt-left', 'background: url(\'/assets/background/grass-dirt-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:58:36', '2017-03-14 20:58:36'),
(39, 1, 'Hierba tierra der', 'grass-dirt-right', 'background: url(\'/assets/background/grass-dirt-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:59:03', '2017-03-14 20:59:03'),
(40, 1, 'Hierba tierra sup-izq', 'grass-dirt-up-left', 'background: url(\'/assets/background/grass-dirt-up-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 20:59:38', '2017-03-14 20:59:38'),
(41, 1, 'Hierba tierra sup-der', 'grass-dirt-up-right', 'background: url(\'/assets/background/grass-dirt-up-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 21:00:04', '2017-03-14 21:00:04'),
(42, 1, 'Hierba tierra inf-izq', 'grass-dirt-down-left', 'background: url(\'/assets/background/grass-dirt-down-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 21:00:35', '2017-03-14 21:00:35'),
(43, 1, 'Hierba tierra inf-der', 'grass-dirt-down-right', 'background: url(\'/assets/background/grass-dirt-down-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 21:01:04', '2017-03-14 21:01:04'),
(44, 1, 'Hierba tierra conector sup-izq', 'grass-dirt-connect-up-left', 'background: url(\'/assets/background/grass-dirt-up-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 21:02:08', '2017-03-14 21:02:08'),
(45, 1, 'Hierba tierra conector sup-der', 'grass-dirt-connect-up-right', 'background: url(\'/assets/background/grass-dirt-up-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 21:03:57', '2017-03-14 21:03:57'),
(46, 1, 'Hierba tierra conector inf-izq', 'grass-dirt-connect-down-left', 'background: url(\'/assets/background/grass-dirt-down-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 21:04:48', '2017-03-14 21:04:48'),
(47, 1, 'Hierba tierra conector inf-der', 'grass-dirt-connect-down-right', 'background: url(\'/assets/background/grass-dirt-down-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-14 21:05:32', '2017-03-14 21:05:32'),
(48, 4, 'Roca sup-izq', 'rock-up-left', 'background: url(\'/assets/background/rock-up-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:12:19', '2017-03-19 19:26:36'),
(49, 4, 'Roca sup', 'rock-up', 'background: url(\'/assets/background/rock-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:13:26', '2017-03-19 19:26:30'),
(50, 4, 'Roca sup-der', 'rock-up-right', 'background: url(\'/assets/background/rock-up-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:14:17', '2017-03-19 19:26:33'),
(51, 4, 'Roca izq', 'rock-left', 'background: url(\'/assets/background/rock-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:14:44', '2017-03-19 19:26:25'),
(52, 4, 'Roca der', 'rock-right', 'background: url(\'/assets/background/rock-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:15:10', '2017-03-19 19:26:15'),
(53, 4, 'Roca inf-izq', 'rock-down-left', 'background: url(\'/assets/background/rock-down-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:15:38', '2017-03-19 19:26:22'),
(54, 4, 'Roca inf-der', 'rock-down-right', 'background: url(\'/assets/background/rock-down-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:16:13', '2017-03-19 19:26:19'),
(55, 4, 'Roca centro', 'rock-center', 'background: url(\'/assets/background/rock-center.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:16:42', '2017-03-19 19:25:49'),
(56, 4, 'Roca burbuja', 'rock-bubble', 'background: url(\'/assets/background/rock-bubble.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:17:08', '2017-03-19 19:21:16'),
(57, 4, 'Roca conector inf-izq', 'rock-connect-down-left', 'background: url(\'/assets/background/rock-down-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:18:12', '2017-03-14 21:18:48'),
(58, 4, 'Roca conector inf-der', 'rock-connet-down-right', 'background: url(\'/assets/background/rock-down-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:19:28', '2017-03-19 19:26:04'),
(59, 4, 'Roca conector sup-izq', 'rock-connect-up-left', 'background: url(\'/assets/background/rock-up-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:20:11', '2017-03-19 19:26:12'),
(60, 4, 'Roca conector sup-der', 'rock-connect-up-right', 'background: url(\'/assets/background/rock-up-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-14 21:21:04', '2017-03-19 19:26:08'),
(61, 3, 'Agua profunda sup', 'water-deep-up', 'background: url(\'/assets/background/water-deep-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:40:07', '2017-03-16 20:40:07'),
(62, 3, 'Agua profunda sup-der', 'water-deep-up-right', 'background: url(\'/assets/background/water-deep-up-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:40:39', '2017-03-16 20:40:39'),
(63, 3, 'Agua profunda der', 'water-deep-right', 'background: url(\'/assets/background/water-deep-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:41:07', '2017-03-16 20:41:07'),
(64, 3, 'Agua profunda inf-der', 'water-deep-down-right', 'background: url(\'/assets/background/water-deep-down-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:41:42', '2017-03-16 20:41:42'),
(65, 3, 'Agua profunda inf', 'water-deep-down', 'background: url(\'/assets/background/water-deep-down.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:42:07', '2017-03-16 20:42:07'),
(66, 3, 'Agua profunda inf-izq', 'water-deep-down-left', 'background: url(\'/assets/background/water-deep-down-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:42:33', '2017-03-16 20:42:33'),
(67, 3, 'Agua profunda izq', 'water-deep-left', 'background: url(\'/assets/background/water-deep-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:43:04', '2017-03-16 20:43:04'),
(68, 3, 'Agua profunda sup-izq', 'water-deep-up-left', 'background: url(\'/assets/background/water-deep-up-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-16 20:43:38', '2017-03-16 20:43:38'),
(69, 1, 'Desierto', 'desert', 'background: url(\'/assets/background/desert.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-16 21:14:21', '2017-03-16 21:14:21'),
(70, 4, 'Hierba montaña inf-izq', 'grass-mountain-down-left', 'background: url(\'/assets/background/grass-mountain-down-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:13:22', '2017-03-18 12:13:22'),
(71, 4, 'Hierba montaña inf', 'grass-mountain-down', 'background: url(\'/assets/background/grass-mountain-down.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:14:16', '2017-03-18 12:14:16'),
(72, 4, 'Hierba montaña inf-der', 'grass-mountain-down-right', 'background: url(\'/assets/background/grass-mountain-down-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:15:07', '2017-03-18 12:15:07'),
(73, 4, 'Hierba montaña inf-izq-izq', 'grass-mountain-down-left-left', 'background: url(\'/assets/background/grass-mountain-down-left-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:16:31', '2017-03-18 12:16:31'),
(74, 4, 'Hierba montaña izq', 'grass-mountain-left', 'background: url(\'/assets/background/grass-mountain-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:17:23', '2017-03-18 12:17:23'),
(75, 4, 'Hierba montaña inf-der-der', 'grass-mountain-down-right-right', 'background: url(\'/assets/background/grass-mountain-down-right-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:18:24', '2017-03-18 12:18:24'),
(76, 4, 'Hierba montaña der', 'grass-mountain-right', 'background: url(\'/assets/background/grass-mountain-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:19:40', '2017-03-18 12:19:40'),
(77, 4, 'Hierba montaña sup-izq', 'grass-mountain-up-left', 'background: url(\'/assets/background/grass-mountain-up-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:20:40', '2017-03-18 12:20:40'),
(78, 4, 'Hierba montaña sup-der', 'grass-mountain-up-right', 'background: url(\'/assets/background/grass-mountain-up-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:21:43', '2017-03-18 12:21:43'),
(79, 4, 'Hierba montaña sup', 'grass-mountain-up', 'background: url(\'/assets/background/grass-mountain-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:22:32', '2017-03-18 12:22:32'),
(80, 4, 'Hierba montaña sup-izq-sup', 'grass-mountain-up-left-up', 'background: url(\'/assets/background/grass-mountain-up-left-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:24:18', '2017-03-18 12:24:18'),
(81, 4, 'Hierba montaña sup-der-sup', 'grass-mountain-up-right-up', 'background: url(\'/assets/background/grass-mountain-up-right-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:25:39', '2017-03-18 12:25:39'),
(82, 4, 'Montaña inf-1', 'mountain-down-1', 'background: url(\'/assets/background/mountain-down-1.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:27:19', '2017-03-18 12:27:19'),
(83, 4, 'Montaña inf-2', 'mountain-down-2', 'background: url(\'/assets/background/mountain-down-2.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:29:08', '2017-03-18 12:29:08'),
(84, 4, 'Montaña inf-izq-1', 'mountain-down-left-1', 'background: url(\'/assets/background/mountain-down-left-1.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:30:15', '2017-03-18 12:30:15'),
(85, 4, 'Montaña inf-izq-2', 'mountain-down-left-2', 'background: url(\'/assets/background/mountain-down-left-2.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:32:36', '2017-03-18 12:32:36'),
(86, 4, 'Montaña inf-izq-izq', 'mountain-down-left-left', 'background: url(\'/assets/background/mountain-down-left-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:33:40', '2017-03-18 12:33:40'),
(87, 4, 'Montaña inf-der-1', 'mountain-down-right-1', 'background: url(\'/assets/background/mountain-down-right-1.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:35:17', '2017-03-18 12:35:17'),
(88, 4, 'Montaña inf-der-2', 'mountain-down-right-2', 'background: url(\'/assets/background/mountain-down-right-2.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:36:26', '2017-03-18 12:36:26'),
(89, 4, 'Montaña inf-der-der', 'mountain-down-right-right', 'background: url(\'/assets/background/mountain-down-right-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:37:26', '2017-03-18 12:37:26'),
(90, 4, 'Montaña izq', 'mountain-left', 'background: url(\'/assets/background/mountain-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:40:15', '2017-03-18 12:40:15'),
(91, 4, 'Montaña der', 'mountain-right', 'background: url(\'/assets/background/mountain-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:41:24', '2017-03-18 12:41:24'),
(92, 4, 'Montaña sup-izq', 'mountain-up-left', 'background: url(\'/assets/background/mountain-up-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:43:43', '2017-03-18 12:43:43'),
(93, 4, 'Montaña sup-der', 'mountain-up-right', 'background: url(\'/assets/background/mountain-up-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 12:44:34', '2017-03-18 12:44:34'),
(94, 4, 'Cumbre sup', 'mountain-top-up', 'background: url(\'/assets/background/mountain-top-up.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 12:59:39', '2017-03-18 12:59:39'),
(95, 4, 'Cumbre sup-izq', 'mountain-top-up-left', 'background: url(\'/assets/background/mountain-top-up-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:00:59', '2017-03-18 13:00:59'),
(96, 4, 'Cumbre conector sup-izq', 'mountain-top-up-left-connector', 'background: url(\'/assets/background/mountain-top-up-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:02:36', '2017-03-18 13:02:36'),
(97, 4, 'Cumbre izq', 'mountain-top-left', 'background: url(\'/assets/background/mountain-top-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:03:14', '2017-03-18 13:03:14'),
(98, 4, 'Cumbre conector inf-izq', 'mountain-top-down-left-connector', 'background: url(\'/assets/background/mountain-top-down-left-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:04:13', '2017-03-18 13:04:13'),
(99, 4, 'Cumbre inf-izq', 'mountain-top-down-left', 'background: url(\'/assets/background/mountain-top-down-left.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:04:54', '2017-03-18 13:04:54'),
(100, 4, 'Cumbre inf', 'mountain-top-down', 'background: url(\'/assets/background/mountain-top-down.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:05:22', '2017-03-18 13:05:22'),
(101, 4, 'Cumbre inf-der', 'mountain-top-down-right', 'background: url(\'/assets/background/mountain-top-down-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:05:56', '2017-03-18 13:05:56'),
(102, 4, 'Cumbre conector inf-der', 'mountain-top-down-right-connector', 'background: url(\'/assets/background/mountain-top-down-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:06:41', '2017-03-18 13:06:41'),
(103, 4, 'Cumbre der', 'mountain-top-right', 'background: url(\'/assets/background/mountain-top-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:07:21', '2017-03-18 13:07:21'),
(104, 4, 'Cumbre conector sup-der', 'mountain-top-up-right-connector', 'background: url(\'/assets/background/mountain-top-up-right-connector.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:08:23', '2017-03-18 13:08:23'),
(105, 4, 'Cumbre sup-der', 'mountain-top-up-right', 'background: url(\'/assets/background/mountain-top-up-right.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:09:13', '2017-03-18 13:09:13'),
(106, 4, 'Cumbre roca 1', 'mountain-top-rock-1', 'background: url(\'/assets/background/mountain-top-rock-1.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:13:15', '2017-03-18 13:13:15'),
(107, 4, 'Cumbre roca 2', 'mountain-top-rock-2', 'background: url(\'/assets/background/mountain-top-rock-2.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:13:33', '2017-03-18 13:13:33'),
(108, 4, 'Cumbre roca 3', 'mountain-top-rock-3', 'background: url(\'/assets/background/mountain-top-rock-3.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 1, '2017-03-18 13:14:03', '2017-03-18 13:14:03'),
(109, 4, 'Montaña conector inf-sup-izq-1', 'mountain-down-top-left-connector-1', 'background: url(\'/assets/background/mountain-down-top-left-connector-1.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 13:54:43', '2017-03-18 13:54:43'),
(110, 4, 'Montaña conector inf-sup-izq-2', 'mountain-down-top-left-connector-2', 'background: url(\'/assets/background/mountain-down-top-left-connector-2.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 13:55:58', '2017-03-18 13:55:58'),
(111, 4, 'Montaña conector inf-sup-der-1', 'mountain-down-top-right-connector-1', 'background: url(\'/assets/background/mountain-down-top-right-connector-1.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 13:56:41', '2017-03-18 13:56:41'),
(112, 4, 'Montaña conector inf-sup-der-2', 'mountain-down-top-right-connector-2', 'background: url(\'/assets/background/mountain-down-top-right-connector-2.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-18 13:57:53', '2017-03-18 13:57:53'),
(113, 4, 'Roca inf', 'rock-down', 'background: url(\'/assets/background/rock-down.png\') no-repeat center center transparent;\nbackground-size: 100% 100% !important;', 0, '2017-03-20 23:29:17', '2017-03-20 23:29:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `background_category`
--

DROP TABLE IF EXISTS `background_category`;
CREATE TABLE `background_category` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `background_category`
--

INSERT INTO `background_category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Suelo', '2017-03-05 00:00:00', NULL),
(2, 'Árboles', '2017-03-05 00:00:00', NULL),
(3, 'Agua', '2017-03-05 00:00:00', NULL),
(4, 'Montaña', '2017-03-05 00:00:00', NULL);

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
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `game`
--

INSERT INTO `game` (`id`, `id_user`, `name`, `id_scenario`, `position_x`, `position_y`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dunedain', 1, 14, 13, '2017-03-05 23:12:31', '2017-03-07 20:17:36'),
(2, 1, NULL, NULL, NULL, NULL, '2017-03-05 23:12:31', '2017-03-05 23:12:31'),
(3, 1, NULL, NULL, NULL, NULL, '2017-03-05 23:12:31', '2017-03-05 23:12:31');

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
(1, 'Inicio', '[[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"41\"},{\"bck\":\"1\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\",\"spr\":\"34\"},{\"bck\":\"1\",\"spr\":\"35\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":\"17\"},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":\"18\"},{\"bck\":\"42\"},{\"bck\":\"46\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"45\"},{\"bck\":\"41\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\",\"spr\":\"36\"},{\"bck\":1,\"spr\":\"37\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":19},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":16},{\"bck\":1,\"spr\":\"20\"},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"39\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1,\"spr\":\"38\"},{\"bck\":1,\"spr\":\"39\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":9},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":19},{\"bck\":1,\"spr\":\"20\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"39\"},{\"bck\":\"1\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":1},{\"bck\":1},{\"bck\":1,\"spr\":2},{\"bck\":1,\"spr\":2},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":6},{\"bck\":\"42\"},{\"bck\":\"46\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"45\"},{\"bck\":\"41\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":24},{\"bck\":26},{\"bck\":26},{\"bck\":26},{\"bck\":26},{\"bck\":26},{\"bck\":\"26\"},{\"bck\":\"26\"},{\"bck\":\"27\"},{\"bck\":\"38\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"45\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":29},{\"bck\":4},{\"bck\":4},{\"bck\":4,\"spr\":24},{\"bck\":4},{\"bck\":4},{\"bck\":\"4\",\"spr\":\"22\"},{\"bck\":\"4\"},{\"bck\":\"28\"},{\"bck\":\"42\"},{\"bck\":\"46\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":40},{\"bck\":36},{\"bck\":41},{\"bck\":1},{\"bck\":24},{\"bck\":25},{\"bck\":\"4\"},{\"bck\":\"34\"},{\"bck\":\"35\"},{\"bck\":\"35\"},{\"bck\":\"35\"},{\"bck\":\"33\"},{\"bck\":\"4\"},{\"bck\":\"30\"},{\"bck\":\"27\"},{\"bck\":\"42\"},{\"bck\":\"46\"},{\"bck\":2},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":40},{\"bck\":44},{\"bck\":2,\"spr\":8},{\"bck\":39},{\"bck\":1},{\"bck\":29},{\"bck\":4,\"spr\":\"22\"},{\"bck\":\"4\"},{\"bck\":\"28\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":\"1\"},{\"bck\":\"29\"},{\"bck\":\"4\"},{\"bck\":\"4\"},{\"bck\":\"28\"},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":2},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":40},{\"bck\":44},{\"bck\":2,\"spr\":7},{\"bck\":2},{\"bck\":\"39\"},{\"bck\":1},{\"bck\":29},{\"bck\":4},{\"bck\":\"4\"},{\"bck\":\"28\"},{\"bck\":\"1\"},{\"bck\":\"1\",\"spr\":\"47\"},{\"bck\":\"1\"},{\"bck\":\"29\"},{\"bck\":\"4\"},{\"bck\":\"4\",\"spr\":\"22\"},{\"bck\":\"28\"},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":2},{\"bck\":2,\"spr\":14}],[{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":38},{\"bck\":2},{\"bck\":2},{\"bck\":2},{\"bck\":\"39\"},{\"bck\":1,\"spr\":4},{\"bck\":32},{\"bck\":33},{\"bck\":\"4\"},{\"bck\":\"28\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"1\"},{\"bck\":\"29\"},{\"bck\":\"4\"},{\"bck\":\"34\"},{\"bck\":\"31\"},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":2,\"spr\":14},{\"bck\":2,\"spr\":14}],[{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":42},{\"bck\":37},{\"bck\":46},{\"bck\":2},{\"bck\":\"39\"},{\"bck\":1,\"spr\":3},{\"bck\":1,\"spr\":3},{\"bck\":\"29\"},{\"bck\":\"4\",\"spr\":\"23\"},{\"bck\":\"30\"},{\"bck\":\"27\"},{\"bck\":\"1\"},{\"bck\":\"24\"},{\"bck\":\"25\"},{\"bck\":\"4\"},{\"bck\":\"28\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":2,\"spr\":14},{\"bck\":2,\"spr\":14}],[{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":42},{\"bck\":37},{\"bck\":\"43\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"32\"},{\"bck\":\"33\"},{\"bck\":\"4\"},{\"bck\":\"28\"},{\"bck\":\"1\"},{\"bck\":\"29\"},{\"bck\":\"4\",\"spr\":\"23\"},{\"bck\":\"34\"},{\"bck\":\"31\"},{\"bck\":1},{\"bck\":1},{\"bck\":\"38\"},{\"bck\":2},{\"bck\":2,\"spr\":14}],[{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":\"11\"},{\"bck\":\"32\"},{\"bck\":\"35\"},{\"bck\":\"31\"},{\"bck\":\"1\"},{\"bck\":\"32\"},{\"bck\":\"35\"},{\"bck\":\"31\"},{\"bck\":1,\"spr\":\"11\"},{\"bck\":1},{\"bck\":\"40\"},{\"bck\":\"44\"},{\"bck\":2},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"13\"},{\"bck\":\"1\",\"spr\":\"27\"},{\"bck\":1},{\"bck\":1,\"spr\":\"27\"},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"12\"},{\"bck\":1,\"spr\":\"13\"},{\"bck\":\"40\"},{\"bck\":\"44\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1,\"spr\":\"42\"},{\"bck\":1,\"spr\":\"43\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"40\"},{\"bck\":\"44\"},{\"bck\":2},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1,\"spr\":\"44\"},{\"bck\":1,\"spr\":\"45\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"40\"},{\"bck\":\"44\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}],[{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":\"1\"},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":1},{\"bck\":\"40\"},{\"bck\":\"44\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"},{\"bck\":\"2\"}]]', 15, 14, 0, '2017-03-04 13:10:01', '2017-03-22 20:58:19');

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
  `breakable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si se puede romper 1 o no 0',
  `grabbable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si se puede coger 1 o no 0',
  `pickable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el sprite se puede coger al inventario 1 o no 0',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sprite`
--

INSERT INTO `sprite` (`id`, `id_category`, `name`, `file`, `crossable`, `breakable`, `grabbable`, `pickable`, `created_at`, `updated_at`) VALUES
(1, 1, 'Arbusto', 'bush', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:42:34'),
(2, 2, 'Roca', 'stone', 0, 0, 1, 0, '2017-03-05 00:00:00', '2017-03-14 20:05:13'),
(3, 1, 'Hierba', 'grass-no-flower', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:42:55'),
(4, 1, 'Hierba flor', 'grass-flower', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:34'),
(5, 1, 'Hierba flores', 'grass-flowers', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:39'),
(6, 3, 'Cartel', 'signal', 0, 0, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:45:03'),
(7, 1, 'Arbusto seco', 'bush-dry', 0, 1, 1, 0, '2017-03-05 00:00:00', '2017-03-22 23:42:40'),
(8, 1, 'Hierba seca', 'grass-dry', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:49'),
(9, 2, 'Piedra pesada', 'stone-heavy', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:39:14'),
(10, 3, 'Valla doble', 'fence-doble', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:17'),
(11, 3, 'Valla abajo', 'fence-down', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:08'),
(12, 3, 'Valla derecha', 'fence-right', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:12'),
(13, 3, 'Valla simple', 'fence-simple', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:24'),
(14, 3, 'Baldosa', 'tile', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:44:57'),
(15, 1, 'Hierba más', 'grass-more', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:44'),
(16, 1, 'Hierba alta', 'tall-grass', 1, 1, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:02'),
(17, 1, 'Hierba alta sup-izq', 'tall-grass-up-left', 1, 1, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:30'),
(18, 1, 'Hierba alta sup-der', 'tall-grass-up-right', 1, 1, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:25'),
(19, 1, 'Hierba alta inf-izq', 'tall-grass-down-left', 1, 1, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:19'),
(20, 1, 'Hierba alta inf-der', 'tall-grass-down-right', 1, 1, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:43:08'),
(21, 3, 'Poste', 'post', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:03'),
(22, 4, 'Ola', 'water-wave', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:41:00'),
(23, 4, 'Onda', 'water-ripple', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:41:05'),
(24, 4, 'Burbujas 1', 'water-bubbles-1', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:40:50'),
(25, 4, 'Burbujas 2', 'water-bubbles-2', 1, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:40:55'),
(26, 4, 'Piedra', 'stone-water', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:41:09'),
(27, 3, 'Valla piedra', 'fence-stone', 0, 0, 0, 0, '2017-03-05 00:00:00', '2017-03-22 23:46:21'),
(30, 2, 'Roca grande sup-izq', 'big-stone-up-left', 0, 0, 0, 0, '2017-03-14 20:45:30', '2017-03-22 23:40:18'),
(31, 2, 'Roca grande sup-der', 'big-stone-up-right', 0, 0, 0, 0, '2017-03-14 20:45:59', '2017-03-22 23:40:14'),
(32, 2, 'Roca grande inf-izq', 'big-stone-down-left', 0, 0, 0, 0, '2017-03-14 20:46:27', '2017-03-22 23:40:08'),
(33, 2, 'Roca grande inf-der', 'big-stone-down-right', 0, 0, 0, 0, '2017-03-14 20:47:03', '2017-03-22 23:40:02'),
(34, 3, 'Estatua sup-izq', 'statue-up-left', 0, 0, 0, 0, '2017-03-14 20:49:56', '2017-03-22 23:45:53'),
(35, 3, 'Estatua sup-der', 'statue-up-right', 0, 0, 0, 0, '2017-03-14 20:50:38', '2017-03-22 23:45:48'),
(36, 3, 'Estatua izq', 'statue-left', 0, 0, 0, 0, '2017-03-14 20:51:06', '2017-03-22 23:45:43'),
(37, 3, 'Estatua der', 'statue-right', 0, 0, 0, 0, '2017-03-14 20:51:35', '2017-03-22 23:45:29'),
(38, 3, 'Estatua inf-izq', 'statue-down-left', 0, 0, 0, 0, '2017-03-14 20:52:06', '2017-03-22 23:45:39'),
(39, 3, 'Estatua inf-der', 'statue-down-right', 0, 0, 0, 0, '2017-03-14 20:52:40', '2017-03-22 23:45:34'),
(40, 1, 'Cactus inf', 'cactus-down', 0, 0, 0, 0, '2017-03-16 21:15:11', '2017-03-22 23:42:44'),
(41, 1, 'Cactus sup', 'cactus-up', 0, 0, 0, 0, '2017-03-16 21:15:36', '2017-03-22 23:42:49'),
(42, 1, 'Arbol cortado sup-izq', 'tree-cut-up-left', 0, 0, 0, 0, '2017-03-16 21:27:14', '2017-03-22 23:42:26'),
(43, 1, 'Arbol cortado sup-der', 'tree-cut-up-right', 0, 0, 0, 0, '2017-03-16 21:27:33', '2017-03-22 23:42:22'),
(44, 1, 'Arbol cortado inf-izq', 'tree-cut-down-left', 0, 0, 0, 0, '2017-03-16 21:28:13', '2017-03-22 23:42:17'),
(45, 1, 'Arbol cortado inf-der', 'tree-cut-down-right', 0, 0, 0, 0, '2017-03-16 21:28:45', '2017-03-22 23:42:11'),
(46, 3, 'Jarrón', 'jar', 0, 1, 1, 0, '2017-03-20 00:01:53', '2017-03-22 23:45:58'),
(47, 3, 'Cofre', 'chest', 0, 0, 0, 0, '2017-03-20 00:06:05', '2017-03-22 23:45:08'),
(48, 3, 'Cofre abierto', 'chest-open', 0, 0, 0, 0, '2017-03-20 00:06:38', '2017-03-22 23:45:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sprite_category`
--

DROP TABLE IF EXISTS `sprite_category`;
CREATE TABLE `sprite_category` (
  `id` int(11) NOT NULL COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sprite_category`
--

INSERT INTO `sprite_category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Arbustos', '2017-03-05 00:00:00', NULL),
(2, 'Rocas', '2017-03-05 00:00:00', NULL),
(3, 'Objetos', '2017-03-05 00:00:00', NULL),
(4, 'Agua', '2017-03-05 00:00:00', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo', AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT de la tabla `background_category`
--
ALTER TABLE `background_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría', AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada partida', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `scenario`
--
ALTER TABLE `scenario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada escenario', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sprite`
--
ALTER TABLE `sprite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo', AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `sprite_category`
--
ALTER TABLE `sprite_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada usuario', AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
