<?php declare(strict_types=1);
class ScenarioData extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'scenario_data';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada dato'
			],
			'id_scenario' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'scenario.id',
				'comment' => 'Id del escenario al que pertenece el dato'
			],
			'type' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tipo de dato 0 fondo 1 objeto 2 personaje'
			],
			'x' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Coordenada X del dato en el escenario'
			],
			'y' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Coordenada Y del dato en el escenario'
			],
			'id_background' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'background.id',
				'comment' => 'Id del fondo del escenario'
			],
			'id_scenario_object' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'scenario_object.id',
				'comment' => 'Id del objeto relacionado que va en el escenario'
			],
			'id_character' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'character.id',
				'comment' => 'Id del personaje que va en el escenario'
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