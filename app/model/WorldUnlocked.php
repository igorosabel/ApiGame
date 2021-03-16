<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class WorldUnlocked extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'world_unlocked';
		$model = [
			'id_game' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'game.id',
				'comment' => 'Id de la partida'
			],
			'id_world' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'world.id',
				'comment' => 'Id del mundo desbloqueado'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($table_name, $model);
	}
}