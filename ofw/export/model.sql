/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

CREATE TABLE `equipment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada equipamiento',
  `id_game` INT(11) NOT NULL COMMENT 'Id de la partida a la que pertenece el equipamiento',
  `head` INT(11) NOT NULL COMMENT 'Id del item que va en la cabeza',
  `necklace` INT(11) NOT NULL COMMENT 'Id del item que va al cuello',
  `body` INT(11) NOT NULL COMMENT 'Id del item que viste',
  `boots` INT(11) NOT NULL COMMENT 'Id del item usado como botas',
  `weapon` INT(11) NOT NULL COMMENT 'Id del item que usa como arma',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada usuario',
  `email` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email del usuario',
  `pass` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contraseña del usuario',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `character` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada tipo de personaje',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del tipo de personaje',
  `id_asset_up` INT(11) NOT NULL COMMENT 'Imagen del personaje al mirar hacia arriba',
  `id_asset_down` INT(11) NOT NULL COMMENT 'Imagen del personaje al mirar hacia abajo',
  `id_asset_left` INT(11) NOT NULL COMMENT 'Imagen del personaje al mirar hacia la izquierda',
  `id_asset_right` INT(11) NOT NULL COMMENT 'Imagen del personaje al mirar hacia la derecha',
  `type` INT(11) NOT NULL COMMENT 'Tipo de personaje NPC 0 Enemigo 1',
  `health` INT(11) NULL COMMENT 'Salud del tipo de personaje',
  `attack` INT(11) NULL COMMENT 'Puntos de daño que hace el tipo de personaje',
  `defense` INT(11) NULL COMMENT 'Puntos de defensa del personaje',
  `speed` INT(11) NULL COMMENT 'Velocidad el tipo de personaje',
  `drop_id_item` INT(11) NOT NULL COMMENT 'Id del elemento que da el tipo de personaje al morir',
  `drop_chance` INT(11) NULL COMMENT 'Porcentaje de veces que otorga premio al morir',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `scenario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único del escenario',
  `id_world` INT(11) NOT NULL COMMENT 'Id del mundo al que pertenece el escenario',
  `name` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del escenario',
  `start_x` INT(11) NULL COMMENT 'Indica la casilla X de la que se sale',
  `start_y` INT(11) NULL COMMENT 'Indica la casilla Y de la que se sale',
  `initial` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si es el escenario inicial 1 o no 0 del mundo',
  `friendly` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el escenario es amistoso',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `character_frame` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada frame del tipo de personaje',
  `id_character` INT(11) NOT NULL COMMENT 'Id del tipo de personaje al que pertenece el frame',
  `id_asset` INT(11) NOT NULL COMMENT 'Id del recurso usado como frame',
  `orientation` INT(11) NOT NULL COMMENT 'Orientación de la imagen del frame 1 arriba 2 derecha 3 abajo 4 izquierda',
  `order` INT(11) NOT NULL COMMENT 'Orden del frame en la animación',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `scenario_object` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada objeto del escenario',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del objeto',
  `id_asset` INT(11) NOT NULL COMMENT 'Id del recurso usado para el objeto',
  `width` INT(11) NOT NULL COMMENT 'Anchura del objeto en casillas',
  `height` INT(11) NOT NULL COMMENT 'Altura del objeto en casillas',
  `crossable` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el objeto se puede cruzar',
  `activable` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el objeto se puede activar 1 o no 0',
  `id_asset_active` INT(11) NOT NULL COMMENT 'Id del recurso usado para el objeto al ser activado',
  `active_time` INT(11) NULL COMMENT 'Tiempo en segundos que el objeto se mantiene activo, 0 para indefinido',
  `active_trigger` INT(11) NULL COMMENT 'Acción que se dispara en caso de que sea activable Mensaje 0 Teleport 1 Custom 2',
  `active_trigger_custom` VARCHAR(200) COLLATE utf8mb4_unicode_ci NULL COMMENT 'Nombre de la acción a ejecutar o mensaje a mostrar en caso de que se active el trigger',
  `pickable` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el objeto se puede coger al inventario 1 o no 0',
  `grabbable` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el objeto se puede levantar 1 o no 0',
  `breakable` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el objeto se puede romper 1 o no 0',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `asset` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada recurso',
  `id_world` INT(11) NOT NULL COMMENT 'Id del mundo en el que se usa el recurso o NULL si sirve para todos',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del recurso',
  `ext` VARCHAR(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Extensión del archivo del recurso',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `game` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada partida',
  `id_user` INT(11) NOT NULL COMMENT 'Id del usuario al que pertenece la partida',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del personaje',
  `id_scenario` INT(11) NOT NULL COMMENT 'Id del escenario en el que está el usuario',
  `position_x` INT(11) NOT NULL COMMENT 'Última posición X guardada del jugador',
  `position_y` INT(11) NOT NULL COMMENT 'Última posición Y guardada del jugador',
  `money` INT(11) NOT NULL COMMENT 'Cantidad de dinero que tiene el jugador',
  `health` INT(11) NOT NULL DEFAULT '100' COMMENT 'Salud actual del jugador',
  `max_health` INT(11) NOT NULL DEFAULT '100' COMMENT 'Máxima salud del jugador',
  `attack` INT(11) NOT NULL COMMENT 'Puntos de daño que hace el personaje',
  `defense` INT(11) NOT NULL COMMENT 'Puntos de defensa del personaje',
  `speed` INT(11) NOT NULL COMMENT 'Puntos de velocidad del personaje',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `scenario_object_drop` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada recurso de un objeto',
  `id_scenario_object` INT(11) NOT NULL COMMENT 'Id del objeto de escenario',
  `id_item` INT(11) NOT NULL COMMENT 'Id del item obtenido',
  `num` INT(11) NOT NULL COMMENT 'Número de items que se obtienen',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `background` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada fondo',
  `id_background_category` INT(11) NOT NULL COMMENT 'Id de la categoría a la que pertenece',
  `id_asset` INT(11) NOT NULL COMMENT 'Id del recurso que se utiliza para el fondo',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del fondo',
  `crossable` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si la casilla se puede cruzar 1 o no 0',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `world_unlocked` (
  `id_game` INT(11) NOT NULL COMMENT 'Id de la partida',
  `id_world` INT(11) NOT NULL COMMENT 'Id del mundo desbloqueado',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id_game`,`id_world`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `background_category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada categoría',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre de la categoría',
  `slug` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slug del nombre de la categoría',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `asset_tag` (
  `id_asset` INT(11) NOT NULL COMMENT 'Id del recurso',
  `id_tag` INT(11) NOT NULL COMMENT 'Id de la tag',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id_asset`,`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `connection` (
  `id_from` INT(11) NOT NULL COMMENT 'Id de un escenario',
  `id_to` INT(11) NOT NULL COMMENT 'Id del escenario con el que conecta',
  `direction` INT(11) NOT NULL COMMENT 'Sentido de la conexión 1 arriba 2 derecha 3 abajo 4 izquierda',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id_from`,`id_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `inventory` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único del elemento del inventario',
  `id_game` INT(11) NOT NULL COMMENT 'Id de la partida en la que está el elemento',
  `id_item` INT(11) NOT NULL COMMENT 'Id del elemento',
  `order` INT(11) NOT NULL COMMENT 'Orden del elemento en el inventario',
  `num` INT(11) NOT NULL COMMENT 'Cantidad del item en el inventario',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `world` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada mundo',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del mundo',
  `description` TEXT COLLATE utf8mb4_unicode_ci NULL COMMENT 'Descripción del mundo',
  `word_one` VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Primera palabra para acceder al mundo',
  `word_two` VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Segunda palabra para acceder al mundo',
  `word_three` VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tercera palabra para acceder al mundo',
  `friendly` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el mundo es amistoso',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `item` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada item',
  `type` INT(11) NOT NULL COMMENT 'Tipo de item 0 moneda 1 arma 2 poción 3 equipamiento 4 objeto',
  `id_asset` INT(11) NOT NULL COMMENT 'Id del recurso usado para el item',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del item',
  `money` INT(11) NULL COMMENT 'Número de monedas que vale al ser comprado o vendido, NULL si no se puede comprar o vender',
  `health` INT(11) NULL COMMENT 'Puntos de daño que cura el item si es una poción o NULL si no lo es',
  `attack` INT(11) NULL COMMENT 'Puntos de daño que hace el item si es un arma o NULL si no lo es',
  `defense` INT(11) NULL COMMENT 'Puntos de defensa que otorga el item si es un equipamiento o NULL si no lo es',
  `speed` INT(11) NULL COMMENT 'Puntos de velocidad que otorga el item si es un equipamiento o NULL si no lo es',
  `wearable` INT(11) NULL COMMENT 'Indica donde se puede equipar en caso de ser equipamiento Cabeza 0 Cuello 1 Cuerpo 2 Botas 3 o NULL si no se puede equipar',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `scenario_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada dato',
  `id_scenario` INT(11) NOT NULL COMMENT 'Id del escenario al que pertenece el dato',
  `type` INT(11) NOT NULL COMMENT 'Tipo de dato 0 fondo 1 objeto 2 personaje',
  `x` INT(11) NOT NULL COMMENT 'Coordenada X del dato en el escenario',
  `y` INT(11) NOT NULL COMMENT 'Coordenada Y del dato en el escenario',
  `id_background` INT(11) NOT NULL COMMENT 'Id del fondo del escenario',
  `id_scenario_object` INT(11) NOT NULL COMMENT 'Id del objeto relacionado que va en el escenario',
  `id_character` INT(11) NOT NULL COMMENT 'Id del personaje que va en el escenario',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `scenario_object_frames` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada frame de un objeto de escenario',
  `id_scenario_object` INT(11) NOT NULL COMMENT 'Id del objeto de escenario que tiene la animación',
  `id_asset` INT(11) NOT NULL COMMENT 'Id del recurso usado como frame',
  `order` INT(11) NOT NULL COMMENT 'Orden del frame en la animación',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `tag` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada tag',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Texto de la tag',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `equipment`
  ADD KEY `fk_equipment_game_idx` (`id_game`),
  ADD KEY `fk_equipment_item_head_idx` (`head`),
  ADD KEY `fk_equipment_item_necklace_idx` (`necklace`),
  ADD KEY `fk_equipment_item_body_idx` (`body`),
  ADD KEY `fk_equipment_item_boots_idx` (`boots`),
  ADD KEY `fk_equipment_item_weapon_idx` (`weapon`),
  ADD CONSTRAINT `fk_equipment_game` FOREIGN KEY (`id_game`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipment_item_head` FOREIGN KEY (`head`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipment_item_necklace` FOREIGN KEY (`necklace`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipment_item_body` FOREIGN KEY (`body`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipment_item_boots` FOREIGN KEY (`boots`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipment_item_weapon` FOREIGN KEY (`weapon`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `character`
  ADD KEY `fk_character_asset_up_idx` (`id_asset_up`),
  ADD KEY `fk_character_asset_down_idx` (`id_asset_down`),
  ADD KEY `fk_character_asset_left_idx` (`id_asset_left`),
  ADD KEY `fk_character_asset_right_idx` (`id_asset_right`),
  ADD KEY `fk_character_item_idx` (`drop_id_item`),
  ADD CONSTRAINT `fk_character_asset_up` FOREIGN KEY (`id_asset_up`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_character_asset_down` FOREIGN KEY (`id_asset_down`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_character_asset_left` FOREIGN KEY (`id_asset_left`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_character_asset_right` FOREIGN KEY (`id_asset_right`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_character_item` FOREIGN KEY (`drop_id_item`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `scenario`
  ADD KEY `fk_scenario_world_idx` (`id_world`),
  ADD CONSTRAINT `fk_scenario_world` FOREIGN KEY (`id_world`) REFERENCES `world` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `character_frame`
  ADD KEY `fk_character_frame_character_idx` (`id_character`),
  ADD KEY `fk_character_frame_asset_idx` (`id_asset`),
  ADD CONSTRAINT `fk_character_frame_character` FOREIGN KEY (`id_character`) REFERENCES `character` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_character_frame_asset` FOREIGN KEY (`id_asset`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `scenario_object`
  ADD KEY `fk_scenario_object_asset_idx` (`id_asset`),
  ADD KEY `fk_scenario_object_asset_active_idx` (`id_asset_active`),
  ADD CONSTRAINT `fk_scenario_object_asset` FOREIGN KEY (`id_asset`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scenario_object_asset_active` FOREIGN KEY (`id_asset_active`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `asset`
  ADD KEY `fk_asset_world_idx` (`id_world`),
  ADD CONSTRAINT `fk_asset_world` FOREIGN KEY (`id_world`) REFERENCES `world` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `game`
  ADD KEY `fk_game_user_idx` (`id_user`),
  ADD KEY `fk_game_scenario_idx` (`id_scenario`),
  ADD CONSTRAINT `fk_game_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_game_scenario` FOREIGN KEY (`id_scenario`) REFERENCES `scenario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `scenario_object_drop`
  ADD KEY `fk_scenario_object_drop_scenario_object_idx` (`id_scenario_object`),
  ADD KEY `fk_scenario_object_drop_item_idx` (`id_item`),
  ADD CONSTRAINT `fk_scenario_object_drop_scenario_object` FOREIGN KEY (`id_scenario_object`) REFERENCES `scenario_object` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scenario_object_drop_item` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `background`
  ADD KEY `fk_background_background_category_idx` (`id_background_category`),
  ADD KEY `fk_background_asset_idx` (`id_asset`),
  ADD CONSTRAINT `fk_background_background_category` FOREIGN KEY (`id_background_category`) REFERENCES `background_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_background_asset` FOREIGN KEY (`id_asset`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `world_unlocked`
  ADD KEY `fk_world_unlocked_game_idx` (`id_game`),
  ADD KEY `fk_world_unlocked_world_idx` (`id_world`),
  ADD CONSTRAINT `fk_world_unlocked_game` FOREIGN KEY (`id_game`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_world_unlocked_world` FOREIGN KEY (`id_world`) REFERENCES `world` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `asset_tag`
  ADD KEY `fk_asset_tag_asset_idx` (`id_asset`),
  ADD KEY `fk_asset_tag_tag_idx` (`id_tag`),
  ADD CONSTRAINT `fk_asset_tag_asset` FOREIGN KEY (`id_asset`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asset_tag_tag` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `connection`
  ADD KEY `fk_connection_scenario_from_idx` (`id_from`),
  ADD KEY `fk_connection_scenario_to_idx` (`id_to`),
  ADD CONSTRAINT `fk_connection_scenario_from` FOREIGN KEY (`id_from`) REFERENCES `scenario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_connection_scenario_to` FOREIGN KEY (`id_to`) REFERENCES `scenario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `inventory`
  ADD KEY `fk_inventory_game_idx` (`id_game`),
  ADD KEY `fk_inventory_item_idx` (`id_item`),
  ADD CONSTRAINT `fk_inventory_game` FOREIGN KEY (`id_game`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventory_item` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `item`
  ADD KEY `fk_item_asset_idx` (`id_asset`),
  ADD CONSTRAINT `fk_item_asset` FOREIGN KEY (`id_asset`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `scenario_data`
  ADD KEY `fk_scenario_data_scenario_idx` (`id_scenario`),
  ADD KEY `fk_scenario_data_background_idx` (`id_background`),
  ADD KEY `fk_scenario_data_scenario_object_idx` (`id_scenario_object`),
  ADD KEY `fk_scenario_data_character_idx` (`id_character`),
  ADD CONSTRAINT `fk_scenario_data_scenario` FOREIGN KEY (`id_scenario`) REFERENCES `scenario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scenario_data_background` FOREIGN KEY (`id_background`) REFERENCES `background` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scenario_data_scenario_object` FOREIGN KEY (`id_scenario_object`) REFERENCES `scenario_object` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scenario_data_character` FOREIGN KEY (`id_character`) REFERENCES `character` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `scenario_object_frames`
  ADD KEY `fk_scenario_object_frames_scenario_object_idx` (`id_scenario_object`),
  ADD KEY `fk_scenario_object_frames_asset_idx` (`id_asset`),
  ADD CONSTRAINT `fk_scenario_object_frames_scenario_object` FOREIGN KEY (`id_scenario_object`) REFERENCES `scenario_object` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scenario_object_frames_asset` FOREIGN KEY (`id_asset`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
