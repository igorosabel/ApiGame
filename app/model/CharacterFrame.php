<?php declare(strict_types=1);
class CharacterFrame extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'character_frame';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada frame del tipo de personaje'
			],
			'id_character' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Id del tipo de personaje al que pertenece el frame'
			],
			'orientation' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 5,
				'comment' => 'Orientación de la imagen del frame'
			],
			'order' => [
				'type'    => OCore::NUM,
				'nullable' => true,
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
	 * Borra completamente un frame con su imagen asociada
	 *
	 * @return void
	 */
	public function deleteFull(): void {
      global $core;
      $ruta = $core->config->getDir('assets').'character/'.$this->getCharacter()->get('slug').'/'.$this->get('file').'.png';
      if (file_exists($ruta)) {
        unlink($ruta);
      }
      $this->delete();
    }

    private ?Character $character = null;

	/**
	 * Obtiene el personaje del frame
	 *
	 * @return Character Personaje del frame
	 */
    public function getCharacter(): Character {
      if (is_null($this->character)) {
        $this->loadCharacter();
      }
      return $this->character;
    }

	/**
	 * Guarda el personaje del frame
	 *
	 * @param Character $char Personaje del frame
	 *
	 * @return void
	 */
    public function setCharacter(Character $char): void {
      $this->character = $char;
    }

	/**
	 * Carga el personaje del frame
	 *
	 * @return void
	 */
    public function loadCharacter(): void {
      $char = new Character();
      $char->find(['id' => $this->get('id_character')]);
      $this->setCharacter($char);
    }

	/**
	 * Obtiene la URL de la imagen del frame
	 *
	 * @return string URL de la imagen del frame
	 */
    public function getUrl(): string {
      return '/assets/character/'.$this->getCharacter()->get('slug').'/'.$this->get('file').'.png';
    }
}