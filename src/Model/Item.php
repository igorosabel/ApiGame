<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class Item extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada item'
			),
			new OModelField(
				name: 'type',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Tipo de item 0 moneda 1 arma 2 poción 3 equipamiento 4 objeto'
			),
			new OModelField(
				name: 'id_asset',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'asset.id',
				comment: 'Id del recurso usado para el item'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 50,
				comment: 'Nombre del item'
			),
			new OModelField(
				name: 'money',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Número de monedas que vale al ser comprado o vendido, NULL si no se puede comprar o vender'
			),
			new OModelField(
				name: 'health',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Puntos de daño que cura el item si es una poción o NULL si no lo es'
			),
			new OModelField(
				name: 'attack',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Puntos de daño que hace el item si es un arma o NULL si no lo es'
			),
			new OModelField(
				name: 'defense',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Puntos de defensa que otorga el item si es un equipamiento o NULL si no lo es'
			),
			new OModelField(
				name: 'speed',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Puntos de velocidad que otorga el item si es un equipamiento o NULL si no lo es'
			),
			new OModelField(
				name: 'wearable',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Indica donde se puede equipar en caso de ser equipamiento Cabeza 0 Cuello 1 Cuerpo 2 Botas 3 o NULL si no se puede equipar'
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
