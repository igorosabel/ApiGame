<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class Character extends OModel {
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único de cada tipo de personaje'
			],
			'name' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del tipo de personaje'
			],
			'width' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Anchura del personaje en casillas'
			],
			'block_width' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Anchura del espacio que bloquea'
			],
			'height' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Altura del personaje en casillas'
			],
			'block_height' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Altura del espacio que bloquea'
			],
			'fixed_position' => [
				'type' => OModel::BOOL,
				'nullable' => false,
				'default' => false,
				'comment' => 'Indica si el personaje se queda quieto o no'
			],
			'id_asset_up' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia arriba'
			],
			'id_asset_down' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia abajo'
			],
			'id_asset_left' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia la izquierda'
			],
			'id_asset_right' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia la derecha'
			],
			'type' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tipo de personaje NPC 0 Enemigo 1'
			],
			'health' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Salud del tipo de personaje'
			],
			'attack' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de daño que hace el tipo de personaje'
			],
			'defense' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de defensa del personaje'
			],
			'speed' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Velocidad el tipo de personaje'
			],
			'drop_id_item' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del elemento que da el tipo de personaje al morir'
			],
			'drop_chance' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Porcentaje de veces que otorga premio al morir'
			],
			'respawn' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tiempo para que vuelva a aparecer el personaje en caso de ser un enemigo'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($model);
	}

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
				$asset_list[$key] = new Asset();
				$asset_list[$key]->find(['id' => $this->get('id_asset_'.$key)]);
			}
		}

		$asset_list['drop'] = null;
		if (!is_null($this->get('drop_id_item'))) {
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
		$drop_item = new Item();
		$drop_item->find(['id' => $this->get('drop_id_item')]);
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
		$sql = "SELECT * FROM `character_frame` WHERE `id_character` = ? ORDER BY `orientation`, `order`";
		$this->db->query($sql, [$this->get('id')]);
		$list = ['up' => [], 'down' => [], 'left' => [], 'right' => []];
		while ($res=$this->db->next()) {
			$character_frame = new CharacterFrame();
			$character_frame->update($res);
			array_push($list[$character_frame->get('orientation')], $character_frame);
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
		$sql = "SELECT * FROM `narrative` WHERE `id_character` = ? ORDER BY `order`";
		$this->db->query($sql, [$this->get('id')]);
		$narratives = [];

		while ($res = $this->db->next()) {
			$narrative = new Narrative();
			$narrative->update($res);
			array_push($narratives, $narrative);
		}

		$this->setNarratives($narratives);
	}
}
