<?php declare(strict_types=1);
class ScenarioObject extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'scenario_object';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada objeto del escenario'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del objeto'
			],
			'id_asset' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado para el objeto'
			],
			'width' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Anchura del objeto en casillas'
			],
			'height' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Altura del objeto en casillas'
			],
			'crossable' => [
				'type'    => OCore::BOOL,
				'comment' => 'Indica si el objeto se puede cruzar'
			],
			'activable' => [
				'type'    => OCore::BOOL,
				'comment' => 'Indica si el objeto se puede activar 1 o no 0'
			],
			'id_asset_active' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado para el objeto al ser activado'
			],
			'active_time' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Tiempo en segundos que el objeto se mantiene activo, 0 para indefinido'
			],
			'active_trigger' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Acción que se dispara en caso de que sea activable Mensaje 0 Teleport 1 Custom 2'
			],
			'active_trigger_custom' => [
				'type'    => OCore::TEXT,
				'nullable' => true,
				'default' => null,
				'size' => 200,
				'comment' => 'Nombre de la acción a ejecutar o mensaje a mostrar en caso de que se active el trigger'
			],
			'pickable' => [
				'type'    => OCore::BOOL,
				'comment' => 'Indica si el objeto se puede coger al inventario 1 o no 0'
			],
			'grabbable' => [
				'type'    => OCore::BOOL,
				'comment' => 'Indica si el objeto se puede levantar 1 o no 0'
			],
			'breakable' => [
				'type'    => OCore::BOOL,
				'comment' => 'Indica si el objeto se puede romper 1 o no 0'
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