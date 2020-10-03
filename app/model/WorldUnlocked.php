<?php declare(strict_types=1);
class WorldUnlocked extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'world_unlocked';
		$model = [
			'id_game' => [
				'type'    => OCore::PK,
				'incr' => false,
				'ref' => 'game.id',
				'comment' => 'Id de la partida'
			],
			'id_world' => [
				'type'    => OCore::PK,
				'incr' => false,
				'ref' => 'world.id',
				'comment' => 'Id del mundo desbloqueado'
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