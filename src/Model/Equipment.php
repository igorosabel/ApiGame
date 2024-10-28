<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Item;

class Equipment extends OModel {
	#[OPK(
	  comment: 'Id único para cada equipamiento'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id de la partida a la que pertenece el equipamiento',
	  nullable: false,
	  ref: 'game.id',
	  default: null
	)]
	public ?int $id_game;

	#[OField(
	  comment: 'Id del item que va en la cabeza',
	  nullable: true,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $head;

	#[OField(
	  comment: 'Id del item que va al cuello',
	  nullable: true,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $necklace;

	#[OField(
	  comment: 'Id del item que viste',
	  nullable: true,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $body;

	#[OField(
	  comment: 'Id del item usado como botas',
	  nullable: true,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $boots;

	#[OField(
	  comment: 'Id del item que usa como arma',
	  nullable: true,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $weapon;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$item = Item::findOne(['id' => $id]);
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
