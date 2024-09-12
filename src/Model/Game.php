<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;
use Osumi\OsumiFramework\App\Model\Equipment;
use Osumi\OsumiFramework\App\Model\Scenario;

class Game extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único de cada partida'
			),
			new OModelField(
				name: 'id_user',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'user.id',
				comment: 'Id del usuario al que pertenece la partida'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 50,
				comment: 'Nombre del personaje'
			),
			new OModelField(
				name: 'id_scenario',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'scenario.id',
				comment: 'Id del escenario en el que está el usuario'
			),
			new OModelField(
				name: 'position_x',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Última posición X guardada del jugador'
			),
			new OModelField(
				name: 'position_y',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Última posición Y guardada del jugador'
			),
			new OModelField(
				name: 'orientation',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 5,
				comment: 'Orientación del personaje al cargar el escenario'
			),
			new OModelField(
				name: 'money',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Cantidad de dinero que tiene el jugador'
			),
			new OModelField(
				name: 'health',
				type: OMODEL_NUM,
				nullable: false,
				default: 100,
				comment: 'Salud actual del jugador'
			),
			new OModelField(
				name: 'max_health',
				type: OMODEL_NUM,
				nullable: false,
				default: 100,
				comment: 'Máxima salud del jugador'
			),
			new OModelField(
				name: 'attack',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Puntos de daño que hace el personaje'
			),
			new OModelField(
				name: 'defense',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Puntos de defensa del personaje'
			),
			new OModelField(
				name: 'speed',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Puntos de velocidad del personaje'
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

	private ?Scenario $scenario = null;

	/**
	 * Obtiene el escenario que se está jugando
	 *
	 * @return Scenario Escenario que se está jugando
	 */
	public function getScenario(): Scenario {
		if (is_null($this->scenario)) {
			$this->loadScenario();
		}
		return $this->scenario;
	}

	/**
	 * Guarda el escenario que se está jugando
	 *
	 * @param Scenario $scenario Escenario que se está jugando
	 *
	 * @return void
	 */
	public function setScenario(Scenario $scenario): void {
		$this->scenario = $scenario;
	}

	/**
	 * Carga el escenario que se está jugando
	 *
	 * @return void
	 */
	public function loadScenario(): void {
		$scenario = new Scenario();
		$scenario->find(['id' => $this->get('id_scenario')]);
		$this->setScenario($scenario);
	}

	private ?array $inventory = null;

	/**
	 * Obtiene el listado de items que componen el inventario del jugador
	 *
	 * @return array Listado de items que componen el inventario del jugador
	 */
	public function getInventory(): array {
		if (is_null($this->inventory)) {
			$this->loadInventory();
		}
		return $this->inventory;
	}

	/**
	 * Guarda el listado de items que componen el inventario del jugador
	 *
	 * @param array $inventory Listado de items que componen el inventario del jugador
	 *
	 * @return void
	 */
	public function setInventory(array $inventory): void {
		$this->inventory = $inventory;
	}

	/**
	 * Carga el listado de items que componen el inventario del jugador
	 *
	 * @return void
	 */
	public function loadInventory(): void {
		$sql = "SELECT * FROM `inventory_item` WHERE `id_game` = ? ORDER BY `order`";
		$this->db->query($sql, [$this->get('id')]);
		$inventory = [];

		while ($res = $this->db->next()) {
			$inventory_item = new InventoryItem();
			$inventory_item->update($res);
			array_push($inventory, $inventory_item);
		}

		$this->setInventory($inventory);
	}

	private ?Equipment $equipment = null;

	/**
	 * Obtiene el equipo del jugador
	 *
	 * @return Equipment Equipo del jugador
	 */
	public function getEquipment(): Equipment {
		if (is_null($this->equipment)) {
			$this->loadEquipment();
		}
		return $this->equipment;
	}

	/**
	 * Guarda el equipo del jugador
	 *
	 * @param Equipment $equipment Equipo del jugador
	 *
	 * @return void
	 */
	public function setEquipment(Equipment $equipment): void {
		$this->equipment = $equipment;
	}

	/**
	 * Carga el equipo del jugador
	 *
	 * @return void
	 */
	public function loadEquipment(): void {
		$equipment = new Equipment();
		$equipment->find(['id_game' => $this->get('id')]);
		$this->setEquipment($equipment);
	}
}
