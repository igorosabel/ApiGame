<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class Item extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'item';
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para cada item'
			],
			'type' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tipo de item 0 moneda 1 arma 2 poción 3 equipamiento 4 objeto'
			],
			'id_asset' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado para el item'
			],
			'name' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del item'
			],
			'money' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Número de monedas que vale al ser comprado o vendido, NULL si no se puede comprar o vender'
			],
			'health' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de daño que cura el item si es una poción o NULL si no lo es'
			],
			'attack' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de daño que hace el item si es un arma o NULL si no lo es'
			],
			'defense' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de defensa que otorga el item si es un equipamiento o NULL si no lo es'
			],
			'speed' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de velocidad que otorga el item si es un equipamiento o NULL si no lo es'
			],
			'wearable' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Indica donde se puede equipar en caso de ser equipamiento Cabeza 0 Cuello 1 Cuerpo 2 Botas 3 o NULL si no se puede equipar'
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

	private ?Asset $asset = null;

	/**
	 * Obtiene el recurso usado para el item
	 *
	 * @return Asset Recurso usado para el item
	 */
	public function getAsset(): Asset {
		if (is_null($this->asset)) {
			$this->loadAsset();
		}
		return $this->asset;
	}

	/**
	 * Guarda el recurso usado para el item
	 *
	 * @param Asset $asset Recurso usado para el item
	 *
	 * @return void
	 */
	public function setAsset(Asset $asset): void {
		$this->asset = $asset;
	}

	/**
	 * Carga el recurso usado para el item
	 *
	 * @return void
	 */
	public function loadAsset(): void {
		$asset = new Asset();
		$asset->find(['id' => $this->get('id_asset')]);
		$this->setAsset($asset);
	}

	private ?array $frames = null;

	/**
	 * Función para obtener los frames del item
	 *
	 * @return array Lista de frames del item
	 */
	public function getFrames(): array {
		if (is_null($this->frames)) {
			$this->loadFrames();
		}
		return $this->frames;
	}

	/**
	 * Guarda los frames del item
	 *
	 * @param array $frames Lista de frames del item
	 *
	 * @return void
	 */
	public function setFrames(array $frames): void {
		$this->frames = $frames;
	}

	/**
	 * Carga la lista de frames del item
	 *
	 * @return void
	 */
	public function loadFrames(): void {
		$sql = "SELECT * FROM `item_frame` WHERE `id_item` = ? ORDER BY `order`";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];
		while ($res=$this->db->next()) {
			$item_frame = new ItemFrame();
			$item_frame->update($res);
			array_push($list, $item_frame);
		}
		$this->setFrames($list);
	}
}