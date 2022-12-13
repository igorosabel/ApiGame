<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;
use OsumiFramework\App\Model\ScenarioObject;
use OsumiFramework\App\Model\Scenario;

class ScenarioObjectFrame extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada frame de un objeto de escenario'
			),
			new OModelField(
				name: 'id_scenario_object',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'scenario_object.id',
				comment: 'Id del objeto de escenario que tiene la animación'
			),
			new OModelField(
				name: 'id_asset',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'asset.id',
				comment: 'Id del recurso usado como frame'
			),
			new OModelField(
				name: 'order',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Orden del frame en la animación'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				nullable: true,
				default: null,
				comment: 'Fecha de última modificación del registro'
			)
		);

		parent::load($model);
	}

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
		$scenario_object = new ScenarioObject();
		$scenario_object->find(['id' => $this->get('id_scenario_object')]);
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
		$asset = new Asset();
		$asset->find(['id' => $this->get('id_asset')]);
		$this->setAsset($asset);
	}
}
