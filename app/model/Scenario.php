<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\App\Model\Connection;

class Scenario extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'scenario';
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único del escenario'
			],
			'id_world' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'world.id',
				'comment' => 'Id del mundo al que pertenece el escenario'
			],
			'name' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Nombre del escenario'
			],
			'start_x' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Indica la casilla X de la que se sale'
			],
			'start_y' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Indica la casilla Y de la que se sale'
			],
			'initial' => [
				'type'    => OModel::BOOL,
				'comment' => 'Indica si es el escenario inicial 1 o no 0 del mundo'
			],
			'friendly' => [
				'type' => OModel::BOOL,
				'nullable' => false,
				'default' => false,
				'comment' => 'Indica si el escenario es amistoso'
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

		parent::load($table_name, $model);
	}
	
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
		$world = new World();
		$world->find(['id' => $this->get('id_world')]);
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
		$sql = "SELECT * FROM `scenario_data` WHERE `id_scenario` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$data = [];

		while ($res = $this->db->next()) {
			$scenario_data = new ScenarioData();
			$scenario_data->update($res);
			array_push($data, $scenario_data);
		}

		$this->setData($data);
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
		$sql = "SELECT * FROM `connection` WHERE `id_from` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$connections = [];

		while ($res = $this->db->next()) {
			$connection = new Connection();
			$connection->update($res);
			array_push($connections, $connection);
		}

		$this->setConnections($connections);
	}

	/**
	 * Obtiene la URL del mapa generado del escenario
	 */
	public function getMapUrl(): string {
		global $core;
		return $core->config->getUrl('base').'/maps/'.$this->get('id_world').'-'.$this->get('id').'.png';
	}

	/**
	 * Borra un escenario con todos sus datos y conexiones
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$sql = "DELETE FROM `connection` WHERE `id_from` = ? OR `id_to` = ?";
		$this->db->query($sql, [$this->get('id'), $this->get('id')]);
		$sql = "DELETE FROM `scenario_data` WHERE `id_scenario` = ?";
		$this->db->query($sql, [$this->get('id')]);

		$this->delete();
	}
}