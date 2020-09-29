<?php declare(strict_types=1);
class BackgroundCategory extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
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

	private ?array $backgrounds = null;

	/**
	 * Guarda la lista de fondos
	 *
	 * @param array $b Lista de fondos
	 *
	 * @return void
	 */
    public function setBackgrounds(array $b): void {
      $this->backgrounds = $b;
    }

	/**
	 * Obtiene la lista de fondos
	 *
	 * @return array Lista de fondos
	 */
    public function getBackgrounds(): array {
      if (is_null($this->backgrounds)) {
        $this->loadBackgrounds();
      }
      return $this->backgrounds;
    }

	/**
	 * Carga la lista de fondos
	 *
	 * @return void
	 */
    public function loadBackgrounds(): void {
      $sql = "SELECT * FROM `background` WHERE `id_category` = ? ORDER BY `name`";
      $this->db->query($sql, [$this->get('id')]);
      $list = [];

      while ($res=$this->db->next()) {
        $bck = new Background();
        $bck->update($res);

        array_push($list, $bck);
      }

      $this->setBackgrounds($list);
    }

	/**
	 * Borra completamente una categoría con todos sus fondos
	 *
	 * @return void
	 */
    public function deleteFull(): void {
      $bcks = $this->getBackgrounds();
      foreach ($bcks as $bck) {
        $bck->delete();
      }
      $this->delete();
    }
}