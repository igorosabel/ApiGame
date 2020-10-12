<?php declare(strict_types=1);
class Character extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'character';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada tipo de personaje'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del tipo de personaje'
			],
			'id_asset_up' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia arriba'
			],
			'id_asset_down' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia abajo'
			],
			'id_asset_left' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia la izquierda'
			],
			'id_asset_right' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia la derecha'
			],
			'type' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tipo de personaje NPC 0 Enemigo 1'
			],
			'health' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Salud del tipo de personaje'
			],
			'attack' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de daño que hace el tipo de personaje'
			],
			'defense' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de defensa del personaje'
			],
			'speed' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Velocidad el tipo de personaje'
			],
			'drop_id_item' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del elemento que da el tipo de personaje al morir'
			],
			'drop_chance' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Porcentaje de veces que otorga premio al morir'
			],
			'respawn' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tiempo para que vuelva a aparecer el personaje en caso de ser un enemigo'
			],
			'created_at' => [
				'type'    => OCore::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OCore::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($table_name, $model);
	}
}