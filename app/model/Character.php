<?php declare(strict_types=1);
class Character extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'character';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada tipo de personaje'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del tipo de personaje'
			],
			'id_asset_up' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia arriba'
			],
			'id_asset_down' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia abajo'
			],
			'id_asset_left' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia la izquierda'
			],
			'id_asset_right' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Imagen del personaje al mirar hacia la derecha'
			],
			'type' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tipo de personaje NPC 0 Enemigo 1'
			],
			'health' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Salud del tipo de personaje'
			],
			'attack' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de daño que hace el tipo de personaje'
			],
			'defense' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Puntos de defensa del personaje'
			],
			'speed' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Velocidad el tipo de personaje'
			],
			'drop_id_item' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'item.id',
				'comment' => 'Id del elemento que da el tipo de personaje al morir'
			],
			'drop_chance' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Porcentaje de veces que otorga premio al morir'
			],
			'respawn' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tiempo para que vuelva a aparecer el personaje en caso de ser un enemigo'
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

	private ?array $asset_list = null;

	/**
	 * Obtiene el recurso usado para el personaje en el sentido indicado
	 *
	 * @param string $sent Sentido del asset a obtener
	 *
	 * @return Asset Recurso usado para el personaje en el sentido indicado
	 */
	public function getAsset(string $sent = null): Asset {
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
		$sql = "SELECT * FROM `asset` WHERE `id` IN ?";
		$params = [
			$this->get('id_asset_up'),
			$this->get('id_asset_down'),
			$this->get('id_asset_left'),
			$this->get('id_asset_right')
		];
		if (!is_null($this->get('drop_id_item'))) {
			array_push($params, $this->get('drop_id_item'));
		}
		$this->db->query($sql, $params);
		$asset_list = ['up' => null, 'down' => null, 'left' => null, 'right' => null, 'drop' => null];

		while ($res=$this->db->next()) {
			$asset = new Asset();
			$asset->update($res);
			switch ($asset->get('id')) {
				case $this->get('id_asset_up'): { $asset_list['up'] = $asset; }
				break;
				case $this->get('id_asset_down'): { $asset_list['down'] = $asset; }
				break;
				case $this->get('id_asset_left'): { $asset_list['left'] = $asset; }
				break;
				case $this->get('id_asset_right'): { $asset_list['right'] = $asset; }
				break;
				case $this->get('drop_id_item'): { $asset_list['drop'] = $asset; }
				break;
			}
		}

		$this->setAssets($asset_list);
	}

	private ?array $frames = null;

	/**
	 * Función para obtener los frames del item
	 *
	 * @return array Lista de frames del item
	 */
	public function getFrames(): array {
		if (is_null($this->frames)) {
			$this->loadFrames();
		}
		return $this->frames;
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
		$list = [];
		while ($res=$this->db->next()) {
			$character_frame = new CharacterFrame();
			$character_frame->update($res);
			array_push($list, $character_frame);
		}
		$this->setFrames($list);
	}
}