<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class ScenarioObjectDrop extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada recurso de un objeto'
			),
			new OModelField(
				name: 'id_scenario_object',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'scenario_object.id',
				comment: 'Id del objeto de escenario'
			),
			new OModelField(
				name: 'id_item',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'item.id',
				comment: 'Id del item obtenido'
			),
			new OModelField(
				name: 'num',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Número de items que se obtienen'
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
