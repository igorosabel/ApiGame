<?php declare(strict_types=1);
class Game extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'game';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada partida'
			],
			'id_user' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Id del usuario al que pertenece la partida'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del personaje'
			],
			'id_scenario' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Id del escenario en el que está el usuario'
			],
			'position_x' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Última posición X guardada del jugador'
			],
			'position_y' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Última posición Y guardada del jugador'
			],
			'money' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Cantidad de dinero que tiene el jugador'
			],
			'health' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Salud actual del jugador'
			],
			'max_health' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Máxima salud del jugador'
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

	private ?Scenario $scenario = null;

	/**
	 * Guarda el escenario en el que está jugador
	 *
	 * @param Scenario $scn Escenario en el que está el jugador
	 *
	 * @return void
	 */
    public function setScenario(Scenario $scn): void {
      $this->scenario = $scn;
    }

	/**
	 * Obtiene el escenario en el que está el jugador
	 *
	 * @return Scenario Escenario en el que está el jugador
	 */
    public function getScenario(): Scenario {
      if (is_null($this->scenario)) {
        $this->loadScenario();
      }
      return $this->scenario;
    }

	/**
	 * Carga el escenario en el que está el jugador
	 *
	 * @return void
	 */
    public function loadScenario(): void {
      $scn = new Scenario();
      $scn->find(['id' => $this->get('id_scenario')]);

      $this->setScenario($scn);
    }
}