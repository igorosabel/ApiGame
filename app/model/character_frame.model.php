<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\App\Model\Character;

class CharacterFrame extends OModel {
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único de cada frame del tipo de personaje'
			],
			'id_character' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'character.id',
				'comment' => 'Id del tipo de personaje al que pertenece el frame'
			],
			'id_asset' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'asset.id',
				'comment' => 'Id del recurso usado como frame'
			],
			'orientation' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 5,
				'comment' => 'Orientación de la imagen del frame up / down / left / right'
			],
			'order' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'comment' => 'Orden del frame en la animación'
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
		$asset = new Asset();
		$asset->find(['id' => $this->get('id_asset')]);
		$this->setAsset($asset);
	}
}
