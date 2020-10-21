<?php declare(strict_types=1);
class Narrative extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'narrative';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada narrativa'
			],
			'id_character' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'character.id',
				'comment' => 'Id del personaje'
			],
			'dialog' => [
				'type'    => OCore::LONGTEXT,
				'nullable' => false,
				'default' => null,
				'comment' => 'Texto del dialogo'
			],
			'order' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del dialogo en la narrativa'
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
	 * Obtiene el personaje de la narrativa
	 *
	 * @return Character Personaje de la narrativa
	 */
	public function getCharacter(): Character {
		if (is_null($this->character)) {
			$this->loadCharacter();
		}
		return $this->character;
	}

	/**
	 * Guarda el personaje de la narrativa
	 *
	 * @param Character $character Personaje de la narrativa
	 */
	public function setCharacter(Character $character): void {
		$this->character = $character;
	}

	/**
	 * Carga el personaje de la narrativa
	 *
	 * @return void
	 */
	public function loadCharacter(): void {
		$character = new Character();
		$character->find(['id' => $this->get('id_character')]);
		$this->setCharacter($character);
	}
}