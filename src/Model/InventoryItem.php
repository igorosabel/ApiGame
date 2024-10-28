<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Item;

class InventoryItem extends OModel {
	#[OPK(
	  comment: 'Id único del elemento del inventario'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id de la partida en la que está el elemento',
	  nullable: false,
	  ref: 'game.id',
	  default: null
	)]
	public ?int $id_game;

	#[OField(
	  comment: 'Id del elemento',
	  nullable: false,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $id_item;

	#[OField(
	  comment: 'Orden del elemento en el inventario',
	  nullable: false,
	  default: null
	)]
	public ?int $order;

	#[OField(
	  comment: 'Cantidad del item en el inventario',
	  nullable: false,
	  default: null
	)]
	public ?int $num;

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
	 * Obtiene el item del inventario
	 *
	 * @return Item Item del inventario
	 */
	public function getItem(): Item {
		if (is_null($this->item)) {
			$this->loadItem();
		}
		return $this->item;
	}

	/**
	 * Guarda el item del inventario
	 *
	 * @param Asset $item Item del inventario
	 *
	 * @return void
	 */
	public function setItem(Item $item): void {
		$this->item = $item;
	}

	/**
	 * Carga el item del inventario
	 *
	 * @return void
	 */
	public function loadItem(): void {
		$item = Item::findOne(['id' => $this->id_item]);
		$this->setItem($item);
	}
}
