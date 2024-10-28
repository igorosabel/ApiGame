<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Item;

class ItemFrame extends OModel {
	#[OPK(
	  comment: 'Id único de cada frame del item'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del item al que pertenece el frame',
	  nullable: false,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $id_item;

	#[OField(
	  comment: 'Id del recurso usado como frame',
	  nullable: false,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset;

	#[OField(
	  comment: 'Orden del frame en la animación',
	  nullable: false,
	  default: null
	)]
	public ?int $order;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$item = Item::findOne(['id' => $this->id_item]);
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
		$asset = Asset::findOne(['id' => $this->id_asset]);
		$this->setAsset($asset);
	}
}
