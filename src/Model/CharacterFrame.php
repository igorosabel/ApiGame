<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Character;

class CharacterFrame extends OModel {
	#[OPK(
	  comment: 'Id único de cada frame del tipo de personaje'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del tipo de personaje al que pertenece el frame',
	  nullable: false,
	  ref: 'character.id',
	  default: null
	)]
	public ?int $id_character;

	#[OField(
	  comment: 'Id del recurso usado como frame',
	  nullable: false,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset;

	#[OField(
	  comment: 'Orientación de la imagen del frame up / down / left / right',
	  nullable: false,
	  max: 5,
	  default: null
	)]
	public ?string $orientation;

	#[OField(
	  comment: 'Orden del frame en la animación',
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
		$character = Character::findOne(['id' => $this->id_character]);
		$this->setCharacter($character);
	}

	private ?Asset $asset = null;

	/**
	 * Obtiene el recurso usado para el frame del personaje
	 *
	 * @return Asset Recurso usado para el frame del personaje
	 */
	public function getAsset(): Asset {
		if (is_null($this->asset)) {
			$this->loadAsset();
		}
		return $this->asset;
	}

	/**
	 * Guarda el recurso usado para el frame del personaje
	 *
	 * @param Asset $asset Recurso usado para el frame del personaje
	 *
	 * @return void
	 */
	public function setAsset(Asset $asset): void {
		$this->asset = $asset;
	}

	/**
	 * Carga el recurso usado para el frame del personaje
	 *
	 * @return void
	 */
	public function loadAsset(): void {
		$asset = Asset::findOne(['id' => $this->id_asset]);
		$this->setAsset($asset);
	}
}
