<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\ScenarioObject;
use Osumi\OsumiFramework\App\Model\Scenario;

class ScenarioObjectFrame extends OModel {
	#[OPK(
	  comment: 'Id único para cada frame de un objeto de escenario'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del objeto de escenario que tiene la animación',
	  nullable: false,
	  ref: 'scenario_object.id',
	  default: null
	)]
	public ?int $id_scenario_object;

	#[OField(
	  comment: 'Id del recurso usado como frame',
	  nullable: false,
	  ref: 'asset.id',
	  default: null
	)]
	public ?int $id_asset;

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

	private ?ScenarioObject $scenario_object = null;

	/**
	 * Obtiene el objeto de escenario del frame
	 *
	 * @return ScenarioObject Objeto de escenario del frame
	 */
	public function getScenarioObject(): ScenarioObject {
		if (is_null($this->scenario_object)) {
			$this->loadScenarioObject();
		}
		return $this->scenario_object;
	}

	/**
	 * Guarda el objeto de escenario del frame
	 *
	 * @param ScenarioObject $scenario_object Objeto de escenario del frame
	 *
	 * @return void
	 */
	public function setScenarioObject(ScenarioObject $scenario_object): void {
		$this->scenario_object = $scenario_object;
	}

	/**
	 * Carga el objeto de escenario del frame
	 *
	 * @return void
	 */
	public function loadScenarioObject(): void {
		$scenario_object = ScenarioObject::findOne(['id' => $this->id_scenario_object]);
		$this->setScenarioObject($scenario_object);
	}

	private ?Asset $asset = null;

	/**
	 * Obtiene el recurso usado para el frame del objeto de escenario
	 *
	 * @return Asset Recurso usado para el frame del objeto de escenario
	 */
	public function getAsset(): Asset {
		if (is_null($this->asset)) {
			$this->loadAsset();
		}
		return $this->asset;
	}

	/**
	 * Guarda el recurso usado para el frame del objeto de escenario
	 *
	 * @param Asset $asset Recurso usado para el frame del objeto de escenario
	 *
	 * @return void
	 */
	public function setAsset(Asset $asset): void {
		$this->asset = $asset;
	}

	/**
	 * Carga el recurso usado para el frame del objeto de escenario
	 *
	 * @return void
	 */
	public function loadAsset(): void {
		$asset = Asset::findOne(['id' => $this->id_asset]);
		$this->setAsset($asset);
	}
}
