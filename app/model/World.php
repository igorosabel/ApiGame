<?php declare(strict_types=1);
class World extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'world';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada mundo'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del mundo'
			],
			'description' => [
				'type'    => OCore::LONGTEXT,
				'nullable' => true,
				'default' => null,
				'comment' => 'Descripción del mundo'
			],
			'word_one' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 20,
				'comment' => 'Primera palabra para acceder al mundo'
			],
			'word_two' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 20,
				'comment' => 'Segunda palabra para acceder al mundo'
			],
			'word_three' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 20,
				'comment' => 'Tercera palabra para acceder al mundo'
			],
			'friendly' => [
				'type' => OCore::BOOL,
				'nullable' => false,
				'default' => false,
				'comment' => 'Indica si el mundo es amistoso'
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

	private ?array $scenarios = null;

	/**
	 * Función para obtener los escenarios de un mundo
	 *
	 * @return array Lista de escenarios del mundo
	 */
	public function getScenarios(): array {
		if (is_null($this->scenarios)) {
			$this->loadScenarios();
		}
		return $this->scenarios;
	}

	/**
	 * Función para guardar los escenarios de un mundo
	 *
	 * @param array $scenarios Lista de escenarios
	 *
	 * @return void
	 */
	public function setScenarios(array $scenarios): void {
		$this->scenarios = $scenarios;
	}

	/**
	 * Función para cargar los escenarios de un mundo
	 *
	 * @return void
	 */
	public function loadScenarios(): void {
		$list = [];
		$sql = "SELECT * FROM `scenario` WHERE `id_world` = ?";
		$this->db->query($sql, [$this->get('id')]);

		while ($res = $this->db->next()) {
			$scenario = new Scenario();
			$scenario->update($res);
			array_push($list, $scenario);
		}

		$this->setScenarios($list);
	}

	private ?Scenario $initial_scenario = null;

	/**
	 * Función para obtener el escenario inicial del mundo
	 *
	 * @return Scenario Escenario inicial del mundo
	 */
	public function getInitialScenario(): ?Scenario {
		if (is_null($this->initial_scenario)) {
			$this->loadInitialScenario();
		}
		return $this->initial_scenario;
	}

	/**
	 * Función para guardar el escenario inicial del mundo
	 *
	 * @param Scenario Escenario inicial
	 *
	 * @return void
	 */
	public function setInitialScenario(Scenario $scenario): void {
		$this->initial_scenario = $scenario;
	}

	/**
	 * Función para cargar el escenario inicial del mundo
	 *
	 * @return void
	 */
	public function loadInitialScenario(): void {
		$sql = "SELECT * FROM `scenario` WHERE `id_world` = ? AND `initial` = 1";
		$this->db->query($sql, [$this->get('id')]);

		if ($res = $this->db->next()) {
			$scenario = new Scenario();
			$scenario->update($res);

			$this->setInitialScenario($scenario);
		}
	}
}