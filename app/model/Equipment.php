<?php declare(strict_types=1);
class Equipment extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'equipment';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada equipamiento'
			],
			'id_game' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'game.id',
				'comment' => 'Id de la partida a la que pertenece el equipamiento'
			],
			'head' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que va en la cabeza'
			],
			'necklace' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que va al cuello'
			],
			'body' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que viste'
			],
			'boots' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item usado como botas'
			],
			'weapon' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que usa como arma'
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