<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Item extends OModel {
	#[OPK(
	  comment: 'Id único para cada item'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Tipo de item 0 moneda 1 arma 2 poción 3 equipamiento 4 objeto',
	  nullable: false,
	  default: null
	)]
	public ?int $type;

	#[OField(
	  comment: 'Id del recurso usado para el item',
	  nullable: false,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset;

	#[OField(
	  comment: 'Nombre del item',
	  nullable: false,
	  max: 50,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Número de monedas que vale al ser comprado o vendido, NULL si no se puede comprar o vender',
	  nullable: true,
	  default: null
	)]
	public ?int $money;

	#[OField(
	  comment: 'Puntos de daño que cura el item si es una poción o NULL si no lo es',
	  nullable: true,
	  default: null
	)]
	public ?int $health;

	#[OField(
	  comment: 'Puntos de daño que hace el item si es un arma o NULL si no lo es',
	  nullable: true,
	  default: null
	)]
	public ?int $attack;

	#[OField(
	  comment: 'Puntos de defensa que otorga el item si es un equipamiento o NULL si no lo es',
	  nullable: true,
	  default: null
	)]
	public ?int $defense;

	#[OField(
	  comment: 'Puntos de velocidad que otorga el item si es un equipamiento o NULL si no lo es',
	  nullable: true,
	  default: null
	)]
	public ?int $speed;

	#[OField(
	  comment: 'Indica donde se puede equipar en caso de ser equipamiento Cabeza 0 Cuello 1 Cuerpo 2 Botas 3 o NULL si no se puede equipar',
	  nullable: true,
	  default: null
	)]
	public ?int $wearable;

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
	 * Obtiene el recurso usado para el item
	 *
	 * @return Asset Recurso usado para el item
	 */
	public function getAsset(): Asset {
		if (is_null($this->asset)) {
			$this->loadAsset();
		}
		return $this->asset;
	}

	/**
	 * Guarda el recurso usado para el item
	 *
	 * @param Asset $asset Recurso usado para el item
	 *
	 * @return void
	 */
	public function setAsset(Asset $asset): void {
		$this->asset = $asset;
	}

	/**
	 * Carga el recurso usado para el item
	 *
	 * @return void
	 */
	public function loadAsset(): void {
		$asset = Asset::findOne(['id' => $this->id_asset]);
		$this->setAsset($asset);
	}

	private ?array $frames = null;

	/**
	 * Función para obtener los frames del item
	 *
	 * @return array Lista de frames del item
	 */
	public function getFrames(): array {
		if (is_null($this->frames)) {
			$this->loadFrames();
		}
		return $this->frames;
	}

	/**
	 * Guarda los frames del item
	 *
	 * @param array $frames Lista de frames del item
	 *
	 * @return void
	 */
	public function setFrames(array $frames): void {
		$this->frames = $frames;
	}

	/**
	 * Carga la lista de frames del item
	 *
	 * @return void
	 */
	public function loadFrames(): void {
		$list = ItemFrame::where(['id_item' => $this->id], ['order_by' => 'order']);
		$this->setFrames($list);
	}
}
