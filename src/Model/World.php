<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;
use Osumi\OsumiFramework\App\Model\Scenario;

class World extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada mundo'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 50,
				comment: 'Nombre del mundo'
			),
			new OModelField(
				name: 'description',
				type: OMODEL_LONGTEXT,
				nullable: true,
				default: null,
				comment: 'Descripción del mundo'
			),
			new OModelField(
				name: 'word_one',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 20,
				comment: 'Primera palabra para acceder al mundo'
			),
			new OModelField(
				name: 'word_two',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 20,
				comment: 'Segunda palabra para acceder al mundo'
			),
			new OModelField(
				name: 'word_three',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 20,
				comment: 'Tercera palabra para acceder al mundo'
			),
			new OModelField(
				name: 'friendly',
				type: OMODEL_BOOL,
				nullable: false,
				default: false,
				comment: 'Indica si el mundo es amistoso'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				nullable: true,
				default: null,
				comment: 'Fecha de última modificación del registro'
			)
		);

		parent::load($model);
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
