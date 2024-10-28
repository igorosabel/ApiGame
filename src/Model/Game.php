<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Equipment;
use Osumi\OsumiFramework\App\Model\Scenario;

class Game extends OModel {
	#[OPK(
	  comment: 'Id único de cada partida'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del usuario al que pertenece la partida',
	  nullable: false,
	  ref: 'user.id',
	  default: null
	)]
	public ?int $id_user;

	#[OField(
	  comment: 'Nombre del personaje',
	  nullable: false,
	  max: 50,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Id del escenario en el que está el usuario',
	  nullable: false,
	  ref: 'scenario.id',
	  default: null
	)]
	public ?int $id_scenario;

	#[OField(
	  comment: 'Última posición X guardada del jugador',
	  nullable: false,
	  default: null
	)]
	public ?int $position_x;

	#[OField(
	  comment: 'Última posición Y guardada del jugador',
	  nullable: false,
	  default: null
	)]
	public ?int $position_y;

	#[OField(
	  comment: 'Orientación del personaje al cargar el escenario',
	  nullable: false,
	  max: 5,
	  default: null
	)]
	public ?string $orientation;

	#[OField(
	  comment: 'Cantidad de dinero que tiene el jugador',
	  nullable: false,
	  default: null
	)]
	public ?int $money;

	#[OField(
	  comment: 'Salud actual del jugador',
	  nullable: false,
	  default: 100
	)]
	public ?int $health;

	#[OField(
	  comment: 'Máxima salud del jugador',
	  nullable: false,
	  default: 100
	)]
	public ?int $max_health;

	#[OField(
	  comment: 'Puntos de daño que hace el personaje',
	  nullable: false,
	  default: null
	)]
	public ?int $attack;

	#[OField(
	  comment: 'Puntos de defensa del personaje',
	  nullable: false,
	  default: null
	)]
	public ?int $defense;

	#[OField(
	  comment: 'Puntos de velocidad del personaje',
	  nullable: false,
	  default: null
	)]
	public ?int $speed;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$scenario = Scenario::findOne(['id' => $this->id_scenario]);
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
		$list = InventoryItem::where(['id_game' => $this->id], ['order_by' => 'order']);
		$this->setInventory($list);
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
		$equipment = Equipment::findOne(['id_game' => $this->id]);
		if (is_null($equipment)) {
			$equipment = Equipment::create();
		}
		$this->setEquipment($equipment);
	}
}
