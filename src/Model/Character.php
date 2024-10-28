<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;

class Character extends OModel {
	#[OPK(
	  comment: 'Id único de cada tipo de personaje'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Nombre del tipo de personaje',
	  nullable: false,
	  max: 50,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Anchura del personaje en casillas',
	  nullable: false,
	  default: null
	)]
	public ?int $width;

	#[OField(
	  comment: 'Anchura del espacio que bloquea',
	  nullable: true,
	  default: null
	)]
	public ?int $block_width;

	#[OField(
	  comment: 'Altura del personaje en casillas',
	  nullable: false,
	  default: null
	)]
	public ?int $height;

	#[OField(
	  comment: 'Altura del espacio que bloquea',
	  nullable: true,
	  default: null
	)]
	public ?int $block_height;

	#[OField(
	  comment: 'Indica si el personaje se queda quieto o no',
	  nullable: false,
	  default: false
	)]
	public ?bool $fixed_position;

	#[OField(
	  comment: 'Imagen del personaje al mirar hacia arriba',
	  nullable: true,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset_up;

	#[OField(
	  comment: 'Imagen del personaje al mirar hacia abajo',
	  nullable: true,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset_down;

	#[OField(
	  comment: 'Imagen del personaje al mirar hacia la izquierda',
	  nullable: true,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset_left;

	#[OField(
	  comment: 'Imagen del personaje al mirar hacia la derecha',
	  nullable: true,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset_right;

	#[OField(
	  comment: 'Tipo de personaje NPC 0 Enemigo 1',
	  nullable: false,
	  default: null
	)]
	public ?int $type;

	#[OField(
	  comment: 'Salud del tipo de personaje',
	  nullable: true,
	  default: null
	)]
	public ?int $health;

	#[OField(
	  comment: 'Puntos de daño que hace el tipo de personaje',
	  nullable: true,
	  default: null
	)]
	public ?int $attack;

	#[OField(
	  comment: 'Puntos de defensa del personaje',
	  nullable: true,
	  default: null
	)]
	public ?int $defense;

	#[OField(
	  comment: 'Velocidad el tipo de personaje',
	  nullable: true,
	  default: null
	)]
	public ?int $speed;

	#[OField(
	  comment: 'Id del elemento que da el tipo de personaje al morir',
	  nullable: true,
	  ref: 'item.id',
	  default: null
	)]
	public ?int $drop_id_item;

	#[OField(
	  comment: 'Porcentaje de veces que otorga premio al morir',
	  nullable: true,
	  default: null
	)]
	public ?int $drop_chance;

	#[OField(
	  comment: 'Tiempo para que vuelva a aparecer el personaje en caso de ser un enemigo',
	  nullable: true,
	  default: null
	)]
	public ?int $respawn;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	private ?array $asset_list = null;

	/**
	 * Obtiene el recurso usado para el personaje en el sentido indicado
	 *
	 * @param string $sent Sentido del asset a obtener
	 *
	 * @return Asset Recurso usado para el personaje en el sentido indicado
	 */
	public function getAsset(string $sent = null): ?Asset {
		if (is_null($this->asset_list)) {
			$this->loadAssets();
		}
		if (is_null($sent)) {
			return $this->asset_list;
		}
		else {
			return $this->asset_list[$sent];
		}
	}

	/**
	 * Guarda los recursos usados para el personaje
	 *
	 * @param array $asset_list Recursos usado para el personaje
	 *
	 * @return void
	 */
	public function setAssets(array $asset_list): void {
		$this->asset_list = $asset_list;
	}

	/**
	 * Carga los recursos usados para el personaje
	 *
	 * @return void
	 */
	public function loadAssets(): void {
		$asset_list = ['up' => null, 'down' => null, 'left' => null, 'right' => null];
		foreach ($asset_list as $key => $value) {
			if (!is_null($this->get('id_asset_'.$key))) {
				$asset_list[$key] = Asset::findOne(['id' => $this->{'id_asset_' . $key}]);
			}
		}

		$asset_list['drop'] = null;
		if (!is_null($this->drop_id_item)) {
			$drop_item = $this->getDropItem();
			$asset_list['drop'] = $drop_item->getAsset();
		}

		$this->setAssets($asset_list);
	}

	private ?Item $drop_item = null;

	/**
	 * Obtiene el item que suelta el personaje
	 *
	 * @return Item Item soltado por el personaje
	 */
	public function getDropItem(): Item {
		if (is_null($this->drop_item)) {
			$this->loadDropItem();
		}
		return $this->drop_item;
	}

	/**
	 * Guarda el item que suelta el personaje
	 *
	 * @param Asset $drop_item Item soltado por el personaje
	 *
	 * @return void
	 */
	public function setDropItem(Item $drop_item): void {
		$this->drop_item = $drop_item;
	}

	/**
	 * Carga el item que suelta el personaje
	 *
	 * @return void
	 */
	public function loadDropItem(): void {
		$drop_item = Item::findOne(['id' => $this->drop_id_item]);
		$this->setDropItem($drop_item);
	}

	private ?array $frames = null;

	/**
	 * Función para obtener los frames del item
	 *
	 * @return array Lista de frames del item
	 */
	public function getFrames(string $sent = null): array {
		if (is_null($this->frames)) {
			$this->loadFrames();
		}
		if (is_null($sent)) {
			return $this->frames;
		}
		else {
			return $this->frames[$sent];
		}
	}

	/**
	 * Guarda los frames del item
	 *
	 * @param array $frames Lista de frames del item
	 *
	 * @return void
	 */
	public function setFrames(array $frames): void {
		$this->frames = $frames;
	}

	/**
	 * Carga la lista de frames del item
	 *
	 * @return void
	 */
	public function loadFrames(): void {
		$db = new ODB();
		$sql = "SELECT * FROM `character_frame` WHERE `id_character` = ? ORDER BY `orientation`, `order`";
		$db->query($sql, [$this->id]);
		$list = ['up' => [], 'down' => [], 'left' => [], 'right' => []];
		while ($res = $db->next()) {
			$character_frame = CharacterFrame::from($res);
			$list[$character_frame->orientation][] = $character_frame;
		}
		$this->setFrames($list);
	}

	private ?array $narratives = null;

	public function getNarratives(): array {
		if (is_null($this->narratives)) {
			$this->loadNarratives();
		}
		return $this->narratives;
	}

	public function setNarratives(array $narratives): void {
		$this->narratives = $narratives;
	}

	public function loadNarratives(): void {
		$list = Narrative::where(['id_character' => $this->id], ['order_by' => 'order']);

		$this->setNarratives($list);
	}
}
