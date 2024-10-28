<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class ScenarioObjectDrop extends OModel {
	#[OPK(
	  comment: 'Id único para cada recurso de un objeto'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del objeto de escenario',
	  nullable: false,
	  ref: 'scenario_object.id',
	  default: null
	)]
	public ?int $id_scenario_object;

	#[OField(
	  comment: 'Id del item obtenido',
	  nullable: false,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $id_item;

	#[OField(
	  comment: 'Número de items que se obtienen',
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
		$item = Item::findOne(['id' => $this->id_item]);
		$this->setItem($item);
	}
}
