<?php declare(strict_types=1);
class Background extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'background';
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

	private ?BackgroundCategory $category = null;

	/**
	 * Obtiene la categoría del fondo
	 *
	 * @return BackgroundCategory Categoría del fondo
	 */
    public function getCategory(): BackgroundCategory {
      if (is_null($this->category)) {
        $this->loadCategory();
      }
      return $this->category;
    }

	/**
	 * Carga la categoría del fondo
	 *
	 * @return void
	 */
    public function loadCategory(): void {
      $bckc = new BackgroundCategory();
      $bckc->find(['id' => $this->get('id_category')]);
      $this->category = $bckc;
    }
}