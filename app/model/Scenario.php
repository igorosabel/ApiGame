<?php declare(strict_types=1);
class Scenario extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'scenario';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único del escenario'
			],
			'id_world' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'world.id',
				'comment' => 'Id del mundo al que pertenece el escenario'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Nombre del escenario'
			],
			'start_x' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Indica la casilla X de la que se sale'
			],
			'start_y' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Indica la casilla Y de la que se sale'
			],
			'initial' => [
				'type'    => OCore::BOOL,
				'comment' => 'Indica si es el escenario inicial 1 o no 0 del mundo'
			],
			'friendly' => [
				'type' => OCore::BOOL,
				'nullable' => false,
				'default' => false,
				'comment' => 'Indica si el escenario es amistoso'
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

	public function deleteFull(): void {
		$sql = "DELETE FROM `connection` WHERE `id_from` = ? OR `id_to` = ?";
		$this->db->query($sql, [$this->get('id'), $this->get('id')]);
		$sql = "DELETE FROM `scenario_data` WHERE `id_scenario` = ?";
		$this->db->query($sql, [$this->get('id')]);

		$this->delete();
	}
}