<?php declare(strict_types=1);
class SpriteCategory extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'sprite_category';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada categoría'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre de la categoría'
			],
			'slug' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Slug del nombre de la categoría'
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

	private ?array $sprites = null;

	/**
	 * Guarda la lista de sprites de la categoría
	 *
	 * @param array $s Lista de sprites de la categoría
	 *
	 * @return void
	 */
	public function setSprites(array $s): void {
		$this->sprites = $s;
	}

	/**
	 * Obtiene la lista de sprites de la categoría
	 *
	 * @return array Lista de sprites de la categoría
	 */
	public function getSprites(): array {
		if (is_null($this->sprites)) {
			$this->loadSprites();
		}
		return $this->sprites;
	}

	/**
	 * Carga la lista de sprites de la categoría
	 *
	 * @return void
	 */
	public function loadSprites(): void {
		$sql = "SELECT * FROM `sprite` WHERE `id_category` = ? ORDER BY `name`";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res=$this->db->next()) {
			$spr = new Sprite();
			$spr->update($res);

			array_push($list, $spr);
		}

		$this->setSprites($list);
	}

	/**
	 * Borra la categoría con todos sus sprites
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$sprs = $this->getSprites();
		foreach ($sprs as $spr) {
			$spr->delete();
		}
		$this->delete();
	}
}