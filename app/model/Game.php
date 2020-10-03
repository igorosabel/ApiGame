<?php declare(strict_types=1);
class Game extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'game';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada partida'
			],
			'id_user' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'user.id',
				'comment' => 'Id del usuario al que pertenece la partida'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del personaje'
			],
			'id_scenario' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'scenario.id',
				'comment' => 'Id del escenario en el que está el usuario'
			],
			'position_x' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Última posición X guardada del jugador'
			],
			'position_y' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Última posición Y guardada del jugador'
			],
			'money' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Cantidad de dinero que tiene el jugador'
			],
			'health' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => '100',
				'comment' => 'Salud actual del jugador'
			],
			'max_health' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => '100',
				'comment' => 'Máxima salud del jugador'
			],
			'attack' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Puntos de daño que hace el personaje'
			],
			'defense' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Puntos de defensa del personaje'
			],
			'speed' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Puntos de velocidad del personaje'
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