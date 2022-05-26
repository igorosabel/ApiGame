<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\App\Model\Character;

class Narrative extends OModel {
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para cada narrativa'
			],
			'id_character' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'character.id',
				'comment' => 'Id del personaje'
			],
			'dialog' => [
				'type'    => OModel::LONGTEXT,
				'nullable' => false,
				'default' => null,
				'comment' => 'Texto del dialogo'
			],
			'order' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del dialogo en la narrativa'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($model);
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
