<?php declare(strict_types=1);
class Connection extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'connection';
		$model = [
			'id_from' => [
				'type'    => OCore::PK,
				'incr' => false,
				'ref' => 'scenario.id',
				'comment' => 'Id de un escenario'
			],
			'id_to' => [
				'type'    => OCore::PK,
				'incr' => false,
				'ref' => 'scenario.id',
				'comment' => 'Id del escenario con el que conecta'
			],
			'direction' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Sentido de la conexión 1 arriba 2 derecha 3 abajo 4 izquierda'
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