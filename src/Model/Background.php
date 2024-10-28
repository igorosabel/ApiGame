<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Background extends OModel {
	#[OPK(
	  comment: 'Id único de cada fondo'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id de la categoría a la que pertenece',
	  nullable: false,
	  ref: 'background_category.id',
	  default: null
	)]
	public ?int $id_background_category;

	#[OField(
	  comment: 'Id del recurso que se utiliza para el fondo',
	  nullable: false,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset;

	#[OField(
	  comment: 'Nombre del fondo',
	  nullable: false,
	  max: 50,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Indica si la casilla se puede cruzar 1 o no 0'
	)]
	public ?bool $crossable;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	private ?Asset $asset = null;

	/**
	 * Obtiene el recurso usado para el fondo
	 *
	 * @return Asset Recurso usado para el fondo
	 */
	public function getAsset(): Asset {
		if (is_null($this->asset)) {
			$this->loadAsset();
		}
		return $this->asset;
	}

	/**
	 * Guarda el recurso usado para el fondo
	 *
	 * @param Asset $asset Recurso usado para el fondo
	 *
	 * @return void
	 */
	public function setAsset(Asset $asset): void {
		$this->asset = $asset;
	}

	/**
	 * Carga el recurso usado para el fondo
	 *
	 * @return void
	 */
	public function loadAsset(): void {
		$asset = Asset::findOne(['id' => $this->id_asset]);
		$this->setAsset($asset);
	}
}
