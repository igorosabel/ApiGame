CREATE TABLE `background` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo',
  `id_category` int(11) NOT NULL COMMENT 'Id de la categoría a la que pertenece',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del fondo',
  `class` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la clase',
  `crossable` tinyint(1) NOT NULL COMMENT 'Indica si la casilla se puede cruzar 1 o no 0',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `sprite_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada partida',
  `id_user` int(11) NOT NULL COMMENT 'Id del usuario al que pertenece la partida',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del personaje',
  `id_scenario` int(11) NOT NULL COMMENT 'Id del escenario en el que está el usuario',
  `position_x` int(11) NOT NULL COMMENT 'Última posición X guardada del jugador',
  `position_y` int(11) NOT NULL COMMENT 'Última posición Y guardada del jugador',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `sprite` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo',
  `id_category` int(11) NOT NULL COMMENT 'Id de la categoría a la que pertenece',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del fondo',
  `class` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la clase',
  `crossable` tinyint(1) NOT NULL COMMENT 'Indica si la casilla se puede cruzar 1 o no 0',
  `breakable` tinyint(1) NOT NULL COMMENT 'Indica si se puede romper 1 o no 0',
  `grabbable` tinyint(1) NOT NULL COMMENT 'Indica si se puede coger 1 o no 0',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `background_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `scenario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada escenario',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del escenario',
  `data` text COMMENT 'Datos que componen el escenario',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada usuario',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email del usuario',
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contraseña del usuario',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `connection` (
  `id_from` int(11) NOT NULL COMMENT 'Id de la categoría en la que está el producto',
  `id_to` int(11) NOT NULL COMMENT 'Id del producto',
  `direction` int(11) NOT NULL COMMENT 'Id del producto',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id_from`,`id_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


