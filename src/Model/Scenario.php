<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Connection;

class Scenario extends OModel {
	#[OPK(
	  comment: 'Id único del escenario'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del mundo al que pertenece el escenario',
	  nullable: false,
	  ref: 'world.id',
	  default: null
	)]
	public ?int $id_world;

	#[OField(
	  comment: 'Nombre del escenario',
	  nullable: false,
	  max: 100,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Indica la casilla X de la que se sale',
	  nullable: true,
	  default: null
	)]
	public ?int $start_x;

	#[OField(
	  comment: 'Indica la casilla Y de la que se sale',
	  nullable: true,
	  default: null
	)]
	public ?int $start_y;

	#[OField(
	  comment: 'Indica si es el escenario inicial 1 o no 0 del mundo'
	)]
	public ?bool $initial;

	#[OField(
	  comment: 'Indica si el escenario es amistoso',
	  nullable: false,
	  default: false
	)]
	public ?bool $friendly;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	private $world = null;

	/**
	 * Obtiene el mundo del escenario
	 *
	 * @return World Mundo del escenario
	 */
	public function getWorld(): World {
		if (is_null($this->world)) {
			$this->loadWorld();
		}
		return $this->world;
	}

	/**
	 * Guarda el mundo del escenario
	 *
	 * @param World $world Mundo del escenario
	 *
	 * @return void
	 */
	public function setWorld(World $world): void {
		$this->world = $world;
	}

	/**
	 * Carga el mundo del escenario
	 *
	 * @return void
	 */
	public function loadWorld(): void {
		$world = World::findOne(['id' => $this->id_world]);
		$this->setWorld($world);
	}

	private ?array $data = null;

	/**
	 * Obtiene los datos de un escenario
	 *
	 * @return array Lista con los datos de un escenario
	 */
	public function getData(): array {
		if (is_null($this->data)) {
			$this->loadData();
		}
		return $this->data;
	}

	/**
	 * Guarda los datos de un escenario
	 *
	 * @param array $data Lista con los datos de un escenario
	 *
	 * @return void
	 */
	public function setData(array $data): void {
		$this->data = $data;
	}

	/**
	 * Carga los datos de un escenario
	 *
	 * @return void
	 */
	public function loadData(): void {
		$list = ScenarioData::where(['id_scenario' => $this->id]);
		$this->setData($list);
	}

	private ?array $connections = null;

	/**
	 * Obtiene la lista de escenarios a los que se conecta un escenario
	 *
	 * @return array Lista de escenarios a los que se conecta
	 */
	public function getConnections(): array {
		if (is_null($this->connections)) {
			$this->loadConnections();
		}
		return $this->connections;
	}

	/**
	 * Guarda la lista de escenarios a los que se conecta un escenario
	 *
	 * @param array $connections Lista de escenarios a los que se conecta
	 *
	 * @return void
	 */
	public function setConnections(array $connections): void {
		$this->connections = $connections;
	}

	/**
	 * Carga la lista de escenarios a los que se conecta un escenario
	 *
	 * @return void
	 */
	public function loadConnections(): void {
		$list = Connection::where(['id_from' => $this->id]);
		$this->setConnections($list);
	}

	/**
	 * Obtiene la URL del mapa generado del escenario
	 */
	public function getMapUrl(): string {
		global $core;
		return $core->config->getUrl('base') . '/maps/' . $this->id_world . '-' . $this->id . '.png';
	}

	/**
	 * Borra un escenario con todos sus datos y conexiones
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$db = new ODB();
		$sql = "DELETE FROM `connection` WHERE `id_from` = ? OR `id_to` = ?";
		$db->query($sql, [$this->id, $this->id]);
		$sql = "DELETE FROM `scenario_data` WHERE `id_scenario` = ?";
		$db->query($sql, [$this->id]);

		$this->delete();
	}
}
