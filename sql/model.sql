CREATE TABLE `scenario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada escenario',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del escenario',
  `data` text COMMENT 'Datos que componen el escenario',
  `start_x` int(11) NOT NULL COMMENT 'Indica la casilla X de la que se sale',
  `start_y` int(11) NOT NULL COMMENT 'Indica la casilla Y de la que se sale',
  `initial` tinyint(1) NOT NULL COMMENT 'Indica si es el escenario inicial 1 o no 0',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `character` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada tipo de personaje',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del tipo de personaje',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Slug del nombre del tipo de personaje',
  `file_up` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia arriba',
  `file_down` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia abajo',
  `file_left` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia la izquierda',
  `file_right` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Imagen del personaje al mirar hacia la derecha',
  `is_npc` tinyint(1) NOT NULL COMMENT 'Indica si el tipo de personaje es un NPC',
  `is_enemy` tinyint(1) NOT NULL COMMENT 'Indica si el tipo de personaje es un enemigo',
  `health` int(11) NOT NULL COMMENT 'Salud del tipo de personaje',
  `attack` int(11) NOT NULL COMMENT 'Daño que hace el tipo de personaje',
  `speed` int(11) NOT NULL COMMENT 'Velocidad el tipo de personaje',
  `drops` int(11) NOT NULL COMMENT 'Id del elemento que da el tipo de personaje',
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


CREATE TABLE `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada partida',
  `id_user` int(11) NOT NULL COMMENT 'Id del usuario al que pertenece la partida',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del personaje',
  `id_scenario` int(11) NOT NULL COMMENT 'Id del escenario en el que está el usuario',
  `position_x` int(11) NOT NULL COMMENT 'Última posición X guardada del jugador',
  `position_y` int(11) NOT NULL COMMENT 'Última posición Y guardada del jugador',
  `money` int(11) NOT NULL COMMENT 'Cantidad de dinero que tiene el jugador',
  `health` int(11) NOT NULL COMMENT 'Salud actual del jugador',
  `max_health` int(11) NOT NULL COMMENT 'Máxima salud del jugador',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `background` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo',
  `id_category` int(11) NOT NULL COMMENT 'Id de la categoría a la que pertenece',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del fondo',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `crossable` tinyint(1) NOT NULL COMMENT 'Indica si la casilla se puede cruzar 1 o no 0',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `background_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Slug del nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `sprite` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo',
  `id_category` int(11) NOT NULL COMMENT 'Id de la categoría a la que pertenece',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del fondo',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `crossable` tinyint(1) NOT NULL COMMENT 'Indica si la casilla se puede cruzar 1 o no 0',
  `width` int(11) NOT NULL COMMENT 'Anchura del sprite en casillas',
  `height` int(11) NOT NULL COMMENT 'Altura del sprite en casillas',
  `frames` int(11) NOT NULL COMMENT 'Número de frames para animar el sprite',
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


CREATE TABLE `sprite_frame` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único del frame',
  `id_sprite` int(11) NOT NULL COMMENT 'Id del sprite al que pertenece el frame',
  `order` int(11) NOT NULL COMMENT 'Orden del frame en la animación',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `sprite_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Slug del nombre de la categoría',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único del elemento del inventario',
  `id_game` int(11) NOT NULL COMMENT 'Id de la partida en la que está el elemento',
  `id_item` int(11) NOT NULL COMMENT 'Id del elemento',
  `order` int(11) NOT NULL COMMENT 'Orden del elemento en el inventario',
  `quantity` int(11) NOT NULL COMMENT 'Cantidad del item en el inventario',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `interactive` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id del elemento interactivo',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del elemento',
  `type` int(11) NOT NULL COMMENT 'Tipo del elemento',
  `activable` tinyint(1) NOT NULL COMMENT 'Indica si el elemento se puede activar',
  `pickable` tinyint(1) NOT NULL COMMENT 'Indica si el elemento se puede coger al inventario',
  `grabbable` tinyint(1) NOT NULL COMMENT 'Indica si el elemento se puede coger',
  `breakable` tinyint(1) NOT NULL COMMENT 'Indica si el elemento se puede romper',
  `crossable` tinyint(1) NOT NULL COMMENT 'Indica si el elemento se puede cruzar',
  `crossable_active` tinyint(1) NOT NULL COMMENT 'Indica si el elemento se puede cruzar una vez activao',
  `sprite_start` int(11) NOT NULL COMMENT 'Sprite inicial del elemento',
  `sprite_active` int(11) NOT NULL COMMENT 'Sprite del elemento al activar',
  `drops` int(11) NOT NULL COMMENT 'Id del elemento que se obtiene al activar o romperlo',
  `quantity` int(11) NOT NULL COMMENT 'Número de elementos que se obtienen al activar o romper',
  `active_time` int(11) NOT NULL COMMENT 'Número de segundos que se mantiene activo, 0 ilimitado',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `character_frame` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada frame del tipo de personaje',
  `id_character` int(11) NOT NULL COMMENT 'Id del tipo de personaje al que pertenece el frame',
  `orientation` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Orientación de la imagen del frame',
  `order` int(11) NOT NULL COMMENT 'Orden del frame en la animación',
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del archivo',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


