<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\ScenarioObjectDrop;

class ScenarioObject extends OModel {
	#[OPK(
	  comment: 'Id único de cada objeto del escenario'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Nombre del objeto',
	  nullable: false,
	  max: 50,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Id del recurso usado para el objeto',
	  nullable: false,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset;

	#[OField(
	  comment: 'Anchura del objeto en casillas',
	  nullable: false,
	  default: null
	)]
	public ?int $width;

	#[OField(
	  comment: 'Anchura del espacio que bloquea',
	  nullable: true,
	  default: null
	)]
	public ?int $block_width;

	#[OField(
	  comment: 'Altura del objeto en casillas',
	  nullable: false,
	  default: null
	)]
	public ?int $height;

	#[OField(
	  comment: 'Altura del espacio que bloquea',
	  nullable: true,
	  default: null
	)]
	public ?int $block_height;

	#[OField(
	  comment: 'Indica si el objeto se puede cruzar'
	)]
	public ?bool $crossable;

	#[OField(
	  comment: 'Indica si el objeto se puede activar 1 o no 0'
	)]
	public ?bool $activable;

	#[OField(
	  comment: 'Id del recurso usado para el objeto al ser activado',
	  nullable: true,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset_active;

	#[OField(
	  comment: 'Tiempo en segundos que el objeto se mantiene activo, 0 para indefinido',
	  nullable: true,
	  default: null
	)]
	public ?int $active_time;

	#[OField(
	  comment: 'Acción que se dispara en caso de que sea activable Mensaje 0 Teleport 1 Custom 2',
	  nullable: true,
	  default: null
	)]
	public ?int $active_trigger;

	#[OField(
	  comment: 'Nombre de la acción a ejecutar o mensaje a mostrar en caso de que se active el trigger',
	  nullable: true,
	  max: 200,
	  default: null
	)]
	public ?string $active_trigger_custom;

	#[OField(
	  comment: 'Indica si el objeto se puede coger al inventario 1 o no 0'
	)]
	public ?bool $pickable;

	#[OField(
	  comment: 'Indica si el objeto se puede levantar 1 o no 0'
	)]
	public ?bool $grabbable;

	#[OField(
	  comment: 'Indica si el objeto se puede romper 1 o no 0'
	)]
	public ?bool $breakable;

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
	 * Obtiene el recurso usado para el objeto de escenario
	 *
	 * @return Asset Recurso usado para el objeto de escenario
	 */
	public function getAsset(): Asset {
		if (is_null($this->asset)) {
			$this->loadAsset();
		}
		return $this->asset;
	}

	/**
	 * Guarda el recurso usado para el objeto de escenario
	 *
	 * @param Asset $asset Recurso usado para el objeto de escenario
	 *
	 * @return void
	 */
	public function setAsset(Asset $asset): void {
		$this->asset = $asset;
	}

	/**
	 * Carga el recurso usado para el objeto de escenario
	 *
	 * @return void
	 */
	public function loadAsset(): void {
		$asset = Asset::findOne(['id' => $this->id_asset]);
		$this->setAsset($asset);
	}

	private ?Asset $asset_active = null;

	/**
	 * Obtiene el recurso usado para el objeto de escenario una vez activado
	 *
	 * @return Asset Recurso usado para el objeto de escenario una vez activado
	 */
	public function getAssetActive(): ?Asset {
		if (is_null($this->asset_active) && !is_null($this->id_asset_active)) {
			$this->loadAssetActive();
		}
		return $this->asset_active;
	}

	/**
	 * Guarda el recurso usado para el objeto de escenario una vez activado
	 *
	 * @param Asset $asset Recurso usado para el objeto de escenario una vez activado
	 *
	 * @return void
	 */
	public function setAssetActive(Asset $asset_active): void {
		$this->asset_active = $asset_active;
	}

	/**
	 * Carga el recurso usado para el objeto de escenario una vez activado
	 *
	 * @return void
	 */
	public function loadAssetActive(): void {
		$asset_active = Asset::findOne(['id' => $this->id_asset_active]);
		$this->setAssetActive($asset_active);
	}

	private ?array $drops = null;

	/**
	 * Obtiene la lista de items que suelta el objeto de escenario
	 *
	 * @return array Lista de items que suelta el objeto de escenario
	 */
	public function getDrops(): array {
		if (is_null($this->drops)) {
			$this->loadDrops();
		}
		return $this->drops;
	}

	/**
	 * Guarda la lista de items que suelta el objeto de escenario
	 *
	 * @param array $drops Lista de items que suelta el objeto de escenario
	 *
	 * @return void
	 */
	public function setDrops(array $drops): void {
		$this->drops = $drops;
	}

	/**
	 * Carga la lista de items que suelta el objeto de escenario
	 *
	 * @return void
	 */
	public function loadDrops(): void {
		$list = ScenarioObjectDrop::where(['id_scenario_object' => $this->id]);
		$this->setDrops($list);
	}

	private ?array $frames = null;

	/**
	 * Obtiene la lista de frames que componen la animación del objeto de escenario
	 *
	 * @return array Lista de frames que componen la animación del objeto de escenario
	 */
	public function getFrames(): array {
		if (is_null($this->frames)) {
			$this->loadFrames();
		}
		return $this->frames;
	}

	/**
	 * Guarda la lista de frames que componen la animación del objeto de escenario
	 *
	 * @param array $frames Lista de frames que componen la animación del objeto de escenario
	 *
	 * @return void
	 */
	public function setFrames(array $frames): void {
		$this->frames = $frames;
	}

	/**
	 * Carga la lista de frames que componen la animación del objeto de escenario
	 *
	 * @return void
	 */
	public function loadFrames(): void {
		$list = ScenarioObjectFrame::where(['id_scenario_object' => $this->id]);
		$this->setFrames($list);
	}
}
