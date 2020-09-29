<?php declare(strict_types=1);
class SpriteFrame extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'sprite_frame';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único del frame'
			],
			'id_sprite' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Id del sprite al que pertenece el frame'
			],
			'order' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del frame en la animación'
			],
			'file' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del archivo'
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
	 * Borra un frame de un sprite con su imagen
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		global $core;
		$ruta = $core->config->getDir('assets').'sprite/'.$this->getSprite()->getCategory()->get('slug').'/'.$this->get('file').'.png';
		if (file_exists($ruta)) {
			unlink($ruta);
		}
		$this->delete();
	}

	private ?Sprite $sprite = null;

	/**
	 * Obtiene el sprite del frame
	 *
	 * @return Sprite Sprite del frame
	 */
	public function getSprite(): Sprite {
		if (is_null($this->sprite)){
			$this->loadSprite();
		}
		return $this->sprite;
	}

	/**
	 * Guarda el sprite del frame
	 *
	 * @param Sprite $spr Sprite del frame
	 *
	 * @return void
	 */
	public function setSprite(Sprite $spr): void {
		$this->sprite = $spr;
	}

	/**
	 * Carga el sprite del frame
	 *
	 * @return void
	 */
	public function loadSprite(): void {
		$spr = new Sprite();
		$spr->find(['id' => $this->get('id_sprite')]);
		$this->setSprite($spr);
	}

	/**
	 * Obtiene la URL de la imagen del sprite
	 *
	 * @return string URL de la iamgen del sprite
	 */
	public function getUrl(): string {
		return '/assets/sprite/'.$this->getSprite()->getCategory()->get('slug').'/'.$this->get('file').'.png';
	}
}