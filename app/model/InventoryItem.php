<?php declare(strict_types=1);
class InventoryItem extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'inventory_item';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único del elemento del inventario'
			],
			'id_game' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'game.id',
				'comment' => 'Id de la partida en la que está el elemento'
			],
			'id_item' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del elemento'
			],
			'order' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del elemento en el inventario'
			],
			'num' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Cantidad del item en el inventario'
			],
			'created_at' => [
				'type'    => OCore::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OCore::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($table_name, $model);
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