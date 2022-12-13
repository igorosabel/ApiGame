<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;
use OsumiFramework\App\Model\Item;

class InventoryItem extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único del elemento del inventario'
			),
			new OModelField(
				name: 'id_game',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'game.id',
				comment: 'Id de la partida en la que está el elemento'
			),
			new OModelField(
				name: 'id_item',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'item.id',
				comment: 'Id del elemento'
			),
			new OModelField(
				name: 'order',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Orden del elemento en el inventario'
			),
			new OModelField(
				name: 'num',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Cantidad del item en el inventario'
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
		$item = new Item();
		$item->find(['id' => $this->get('id_item')]);
		$this->setItem($item);
	}
}
