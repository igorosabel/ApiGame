<?php declare(strict_types=1);
class BackgroundCategory extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'background_category';
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

	private ?array $backgrounds = null;

	/**
	 * Obtiene la lista de fondos de una categoría
	 *
	 * @return array Lista de fondos de una categoría
	 */
	public function getBackgrounds(): array {
		if (is_null($this->backgrounds)) {
			$this->loadBackgrounds();
		}
		return $this->backgrounds;
	}

	/**
	 * Guarda la lista de fondos de una categoría
	 *
	 * @param array $backgrounds Lista de fondos de una categoría
	 *
	 * @return void
	 */
	public function setBackgrounds(array $backgrounds): void {
		$this->backgrounds = $backgrounds;
	}

	/**
	 * Carga la lista de fondos de una categoría
	 *
	 * @return void
	 */
	public function loadBackgrounds(): void {
		$sql = "SELECT * FROM `background` WHERE `id_background_category` = ? ORDER BY `name`";
		$this->db->query($sql, [$this->get('id')]);
		$backgrounds = [];

		while ($res = $this->db->next()) {
			$background = new Background();
			$background->update($res);
			array_push($backgrounds, $background);
		}

		$this->setBackgrounds($backgrounds);
	}
}