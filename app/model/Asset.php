<?php declare(strict_types=1);
class Asset extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'asset';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada recurso'
			],
			'id_world' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'world.id',
				'comment' => 'Id del mundo en el que se usa el recurso o NULL si sirve para todos'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del recurso'
			],
			'ext' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 5,
				'comment' => 'Extensión del archivo del recurso'
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
	 * Función para obtener la URL al recurso
	 *
	 * @return string URL del recurso
	 */
	public function getUrl(): string {
		global $core;
		return $core->config->getUrl('base').'/assets/'.$this->get('id').'.'.$this->get('ext');
	}

	/**
	 * Función para obtener la ruta física al archivo del recurso
	 *
	 * @return string Ruta al archivo
	 */
	public function getFile(): string {
		global $core;
		return $core->config->getDir('assets').$this->get('id').'.'.$this->get('ext');
	}

	private ?array $tags = null;

	/**
	 * Obtiene la lista de tags del recurso
	 *
	 * @return array Lista de tags
	 */
	public function getTags(): array {
		if (is_null($this->tags)) {
			$this->loadTags();
		}
		return $this->tags;
	}

	/**
	 * Guarda la lista de tags
	 *
	 * @param array $tags Lista de tags
	 *
	 * @return void
	 */
	public function setTags(array $tags):  void {
		$this->tags = $tags;
	}

	/**
	 * Carga la lista de tags
	 *
	 * @return void
	 */
	public function loadTags(): void {
		$sql = "SELECT * FROM `tag` WHERE `id` IN (SELECT `id_tag` FROM `asset_tag` WHERE `id_asset` = ?)";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res = $this->db->next()) {
			$tag = new Tag();
			$tag->update($res);
			array_push($list, $tag);
		}

		$this->setTags($list);
	}

	/**
	 * Obtiene la lista de tags como una cadena de texto
	 *
	 * @return string Lista de tags como una cadena de texto
	 */
	public function getTagsAsString(): string {
		$list = $this->getTags();
		$tags = [];
		foreach ($list as $tag) {
			array_push($tags, $tag->get('name'));
		}

		return implode(', ', $tags);
	}

	/**
	 * Función para borrar un recurso junto a su imagen
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$route = $this->getFile();
		if (file_exists($route)) {
			unlink($route);
		}
		$this->delete();
	}
}