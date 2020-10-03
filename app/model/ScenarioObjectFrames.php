<?php declare(strict_types=1);
class ScenarioObjectFrames extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'scenario_object_frames';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada frame de un objeto de escenario'
			],
			'id_scenario_object' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'scenario_object.id',
				'comment' => 'Id del objeto de escenario que tiene la animación'
			],
			'id_asset' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado como frame'
			],
			'order' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del frame en la animación'
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