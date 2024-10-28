<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Character;

class Narrative extends OModel {
	#[OPK(
	  comment: 'Id único para cada narrativa'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del personaje',
	  nullable: false,
	  ref: 'character.id',
	  default: null
	)]
	public ?int $id_character;

	#[OField(
	  comment: 'Texto del dialogo',
	  nullable: false,
	  default: null,
	  type: OField::LONGTEXT
	)]
	public ?string $dialog;

	#[OField(
	  comment: 'Orden del dialogo en la narrativa',
	  nullable: false,
	  default: null
	)]
	public ?int $order;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$character = Character::findOne(['id' => $this->id_character]);
		$this->setCharacter($character);
	}
}
