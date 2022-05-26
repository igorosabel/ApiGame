<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\App\Model\Item;

class ItemFrame extends OModel {
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único de cada frame del item'
			],
			'id_item' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item al que pertenece el frame'
			],
			'id_asset' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado como frame'
			],
			'order' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del frame en la animación'
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

	private ?Item $item = null;

	/**
	 * Obtiene el item del frame
	 *
	 * @return Item Item del frame
	 */
	public function getItem(): Item {
		if (is_null($this->item)) {
			$this->loadItem();
		}
		return $this->item;
	}

	/**
	 * Guarda el item del frame
	 *
	 * @param Item $item Item del frame
	 */
	public function setItem(Item $item): void {
		$this->item = $item;
	}

	/**
	 * Carga el item del frame
	 *
	 * @return void
	 */
	public function loadItem(): void {
		$item = new Item();
		$item->find(['id' => $this->get('id_item')]);
		$this->setItem($item);
	}

	private ?Asset $asset = null;

	/**
	 * Obtiene el recurso usado para el frame del item
	 *
	 * @return Asset Recurso usado para el frame del item
	 */
	public function getAsset(): Asset {
		if (is_null($this->asset)) {
			$this->loadAsset();
		}
		return $this->asset;
	}

	/**
	 * Guarda el recurso usado para el frame del item
	 *
	 * @param Asset $asset Recurso usado para el frame del item
	 *
	 * @return void
	 */
	public function setAsset(Asset $asset): void {
		$this->asset = $asset;
	}

	/**
	 * Carga el recurso usado para el frame del item
	 *
	 * @return void
	 */
	public function loadAsset(): void {
		$asset = new Asset();
		$asset->find(['id' => $this->get('id_asset')]);
		$this->setAsset($asset);
	}
}
