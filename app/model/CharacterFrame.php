<?php declare(strict_types=1);
class CharacterFrame extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'character_frame';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada frame del tipo de personaje'
			],
			'id_character' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'character.id',
				'comment' => 'Id del tipo de personaje al que pertenece el frame'
			],
			'id_asset' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado como frame'
			],
			'orientation' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orientación de la imagen del frame 1 arriba 2 derecha 3 abajo 4 izquierda'
			],
			'order' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del frame en la animación'
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
	 * @param Character $character Personaje del frame
	 */
	public function setCharacter(Character $character): void {
		$this->character = $character;
	}

	/**
	 * Carga el personaje del frame
	 *
	 * @return void
	 */
	public function loadCharacter(): void {
		$character = new Character();
		$character->find(['id' => $this->get('id_character')]);
		$this->setCharacter($character);
	}
}