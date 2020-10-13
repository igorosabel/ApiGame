<?php declare(strict_types=1);
class ScenarioObjectFrame extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'scenario_object_frame';
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

	private ?ScenarioObject $scenario_object = null;

	/**
	 * Obtiene el objeto de escenario del frame
	 *
	 * @return ScenarioObject Objeto de escenario del frame
	 */
	public function getScenarioObject(): ScenarioObject {
		if (is_null($this->scenario_object)) {
			$this->loadScenarioObject();
		}
		return $this->scenario_object;
	}

	/**
	 * Guarda el objeto de escenario del frame
	 *
	 * @param ScenarioObject $scenario_object Objeto de escenario del frame
	 *
	 * @return void
	 */
	public function setScenarioObject(ScenarioObject $scenario_object): void {
		$this->scenario_object = $scenario_object;
	}

	/**
	 * Carga el objeto de escenario del frame
	 *
	 * @return void
	 */
	public function loadScenarioObject(): void {
		$scenario_object = new ScenarioObject();
		$scenario_object->find(['id' => $this->get('id_scenario_object')]);
		$this->setScenarioObject($scenario_object);
	}
}