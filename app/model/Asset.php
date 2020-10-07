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
		return '/assets/'.$this->get('id').'.'.$this->get('ext');
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
}