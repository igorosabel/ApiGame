<?php declare(strict_types=1);
class Scenario extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'scenario';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada escenario'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 200,
				'comment' => 'Nombre del escenario'
			],
			'data' => [
				'type'    => OCore::LONGTEXT,
				'nullable' => false,
				'default' => null,
				'comment' => 'Datos que componen el escenario'
			],
			'start_x' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica la casilla X de la que se sale'
			],
			'start_y' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica la casilla Y de la que se sale'
			],
			'initial' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si es el escenario inicial 1 o no 0'
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