<?php declare(strict_types=1);
class Sprite extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'sprite';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada fondo'
			],
			'id_category' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Id de la categoría a la que pertenece'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del fondo'
			],
			'file' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del archivo'
			],
			'crossable' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si la casilla se puede cruzar 1 o no 0'
			],
			'width' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Anchura del sprite en casillas'
			],
			'height' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Altura del sprite en casillas'
			],
			'frames' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Número de frames para animar el sprite'
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

	/**
	 * Borra un sprite con todos sus frames e imágenes
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		global $core;

		$frames = $this->getFrames();
		foreach ($frames as $fr) {
			$fr->setSprite($this);
			$fr->deleteFull();
		}

		$ruta = $core->config->getDir('assets').'sprite/'.$this->getCategory()->get('slug').'/'.$this->get('file').'.png';
		if (file_exists($ruta)) {
			unlink($ruta);
		}

		$this->delete();
	}

	private ?SpriteCategory $category = null;

	/**
	 * Obtiene la categoría del sprite
	 *
	 * @return SpriteCategory Categoría del sprite
	 */
	public function getCategory(): SpriteCategory {
		if (is_null($this->category)) {
			$this->loadCategory();
		}
		return $this->category;
	}

	/**
	 * Carga la categoría del sprite
	 *
	 * @return void
	 */
	public function loadCategory(): void {
		$sprc = new SpriteCategory();
		$sprc->find(['id' => $this->get('id_category')]);
		$this->category = $sprc;
	}

	private ?array $frames = null;

	/**
	 * Obtiene los frames del sprite
	 *
	 * @return array Lista de frames del sprite
	 */
	public function getFrames(): array {
		if (is_null($this->frames)) {
			$this->loadFrames();
		}
		return $this->frames;
	}

	/**
	 * Carga la lista de frames del sprite
	 *
	 * @return void
	 */
	public function loadFrames(): void {
		$list = [];
		$sql = "SELECT * FROM `sprite_frame` WHERE `id_sprite` = ? ORDER BY `order`";
		$this->db->query($sql, [$this->get('id')]);
		while ($res=$this->db->next()) {
			$sprf = new SpriteFrame();
			$sprf->update($res);
			array_push($list, $sprf);
		}
		$this->frames = $list;
	}

	/**
	 * Obtiene la URL de la imagen del sprite
	 *
	 * @return string URL de la imagen del sprite
	 */
	public function getUrl(): string {
		return '/assets/sprite/'.$this->getCategory()->get('slug').'/'.$this->get('file').'.png';
	}
}