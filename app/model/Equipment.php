<?php declare(strict_types=1);
class Equipment extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'equipment';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada equipamiento'
			],
			'id_game' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'game.id',
				'comment' => 'Id de la partida a la que pertenece el equipamiento'
			],
			'head' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que va en la cabeza'
			],
			'necklace' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que va al cuello'
			],
			'body' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que viste'
			],
			'boots' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item usado como botas'
			],
			'weapon' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item que usa como arma'
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
	
	private ?array $items = null;
	
	/**
	 * Obtiene el listado de items que componen el equipo del jugador
	 *
	 * @return array Listado de items que componen el equipo del jugador
	 */
	public function getAllItems(): array {
		if (is_null($this->items)) {
			$this->loadAllItems();
		}
		return $this->items;
	}

	/**
	 * Guarda el listado de items que componen el equipo del jugador
	 *
	 * @param array $inventory Listado de items que componen el equipo del jugador
	 *
	 * @return void
	 */
	public function setAllItems(array $items): void {
		$this->items = $items;
	}

	/**
	 * Carga el listado de items que componen el equipo del jugador
	 *
	 * @return void
	 */
	public function loadAllItems(): void {
		$items = [];
		$item_list = ['head', 'necklace', 'body', 'boots', 'weapon'];

		foreach ($item_list as $item_name) {
			if (!is_null($this->get($item_name))) {
				$items[$item_name] = $this->getItem($this->get($item_name));
			}
		}

		$this->setAllItems($items);
	}

	/**
	 * Función para obtener un item
	 *
	 * @param int Id del item a buscar
	 *
	 * @return Item Item indicado
	 */
	public function getItem(int $id): Item {
		$item = new Item();
		$item->find(['id' => $id]);
		return $item;
	}

	/**
	 * Obtiene el item equipado en el lugar indicado, si lo tiene
	 *
	 * @param string $where Lugar indicado
	 *
	 * @return Item Item equipado en la cabeza
	 */
	public function getEquippedItem(string $where): ?Item {
		if (is_null($this->items)) {
			$this->loadAllItems();
		}
		return array_key_exists($where, $this->items) ? $this->items[$where] : null;
	}
}