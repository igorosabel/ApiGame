<?php declare(strict_types=1);
class Interactive extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'interactive';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id del elemento interactivo'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del elemento'
			],
			'type' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Tipo del elemento'
			],
			'activable' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el elemento se puede activar'
			],
			'pickable' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el elemento se puede coger al inventario'
			],
			'grabbable' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el elemento se puede coger'
			],
			'breakable' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el elemento se puede romper'
			],
			'crossable' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el elemento se puede cruzar'
			],
			'crossable_active' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el elemento se puede cruzar una vez activado'
			],
			'sprite_start' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Sprite inicial del elemento'
			],
			'sprite_active' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Sprite del elemento al activar'
			],
			'drops' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Id del elemento que se obtiene al activar o romperlo'
			],
			'quantity' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Número de elementos que se obtienen al activar o romper'
			],
			'active_time' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => 0,
				'comment' => 'Número de segundos que se mantiene activo, 0 ilimitado'
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

	private ?Sprite $sprite_start = null;
	private ?Sprite $sprite_active   = null;

	/**
	 * Carga el sprite inicial
	 *
	 * @return void
	 */
	public function loadSpriteStart(): void {
	  $sprs = new Sprite();
	  $sprs->find(['id' => $this->get('sprite_start')]);
	  $this->sprite_start = $sprs;
	}

	/**
	 * Carga el sprite activo
	 *
	 * @return void
	 */
	public function loadSpriteActive(): void {
	  $spra = new Sprite();
	  $spra->find(['id' => $this->get('sprite_active')]);
	  $this->sprite_active = $spra;
	}

	/**
	 * Obtiene el sprite inicial
	 *
	 * @return Sprite Sprite inicial
	 */
	public function getSpriteStart(): Sprite {
	  if (is_null($this->sprite_start)) {
		$this->loadSpriteStart();
	  }
	  return $this->sprite_start;
	}

	/**
	 * Obtiene el sprite activo
	 *
	 * @return Sprite Sprite activo
	 */
	public function getSpriteActive(): Sprite {
	  if (is_null($this->sprite_active)) {
		$this->loadSpriteActive();
	  }
	  return $this->sprite_active;
	}
}