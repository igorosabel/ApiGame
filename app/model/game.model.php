<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\App\Model\Equipment;
use OsumiFramework\App\Model\Scenario;

class Game extends OModel {
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único de cada partida'
			],
			'id_user' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'user.id',
				'comment' => 'Id del usuario al que pertenece la partida'
			],
			'name' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del personaje'
			],
			'id_scenario' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'scenario.id',
				'comment' => 'Id del escenario en el que está el usuario'
			],
			'position_x' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Última posición X guardada del jugador'
			],
			'position_y' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Última posición Y guardada del jugador'
			],
			'orientation' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 5,
				'comment' => 'Orientación del personaje al cargar el escenario'
			],
			'money' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Cantidad de dinero que tiene el jugador'
			],
			'health' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => '100',
				'comment' => 'Salud actual del jugador'
			],
			'max_health' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => '100',
				'comment' => 'Máxima salud del jugador'
			],
			'attack' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Puntos de daño que hace el personaje'
			],
			'defense' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Puntos de defensa del personaje'
			],
			'speed' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Puntos de velocidad del personaje'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($model);
	}

	private $scenario = null;

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
