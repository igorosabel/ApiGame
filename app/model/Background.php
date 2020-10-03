<?php declare(strict_types=1);
class Background extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'background';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada fondo'
			],
			'id_background_category' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'background_category.id',
				'comment' => 'Id de la categoría a la que pertenece'
			],
			'id_asset' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso que se utiliza para el fondo'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del fondo'
			],
			'crossable' => [
				'type'    => OCore::BOOL,
				'comment' => 'Indica si la casilla se puede cruzar 1 o no 0'
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