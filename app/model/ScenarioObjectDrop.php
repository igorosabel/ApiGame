<?php declare(strict_types=1);
class ScenarioObjectDrop extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'scenario_object_drop';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada recurso de un objeto'
			],
			'id_scenario_object' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'scenario_object.id',
				'comment' => 'Id del objeto de escenario'
			],
			'id_item' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del item obtenido'
			],
			'num' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Número de items que se obtienen'
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
	 * Obtiene el item soltado por el objeto de escenario
	 *
	 * @return Item Item soltado por el objeto de escenario
	 */
	public function getItem(): Item {
		if (is_null($this->item)) {
			$this->loadItem();
		}
		return $this->item;
	}

	/**
	 * Guarda el item soltado por el objeto de escenario
	 *
	 * @param Item $item Item soltado por el objeto de escenario
	 *
	 * @return void
	 */
	public function setItem(Item $item): void {
		$this->item = $item;
	}

	/**
	 * Carga el item soltado por el objeto de escenario
	 *
	 * @return void
	 */
	public function loadItem(): void {
		$item = new Item();
		$item->find(['id' => $this->get('id_item')]);
		$this->setItem($item);
	}
}