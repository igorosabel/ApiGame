<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;
use Osumi\OsumiFramework\App\Model\ScenarioObjectDrop;

class ScenarioObject extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único de cada objeto del escenario'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 50,
				comment: 'Nombre del objeto'
			),
			new OModelField(
				name: 'id_asset',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'asset.id',
				comment: 'Id del recurso usado para el objeto'
			),
			new OModelField(
				name: 'width',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Anchura del objeto en casillas'
			),
			new OModelField(
				name: 'block_width',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Anchura del espacio que bloquea'
			),
			new OModelField(
				name: 'height',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				comment: 'Altura del objeto en casillas'
			),
			new OModelField(
				name: 'block_height',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Altura del espacio que bloquea'
			),
			new OModelField(
				name: 'crossable',
				type: OMODEL_BOOL,
				comment: 'Indica si el objeto se puede cruzar'
			),
			new OModelField(
				name: 'activable',
				type: OMODEL_BOOL,
				comment: 'Indica si el objeto se puede activar 1 o no 0'
			),
			new OModelField(
				name: 'id_asset_active',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				ref: 'asset.id',
				comment: 'Id del recurso usado para el objeto al ser activado'
			),
			new OModelField(
				name: 'active_time',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Tiempo en segundos que el objeto se mantiene activo, 0 para indefinido'
			),
			new OModelField(
				name: 'active_trigger',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				comment: 'Acción que se dispara en caso de que sea activable Mensaje 0 Teleport 1 Custom 2'
			),
			new OModelField(
				name: 'active_trigger_custom',
				type: OMODEL_TEXT,
				nullable: true,
				default: null,
				size: 200,
				comment: 'Nombre de la acción a ejecutar o mensaje a mostrar en caso de que se active el trigger'
			),
			new OModelField(
				name: 'pickable',
				type: OMODEL_BOOL,
				comment: 'Indica si el objeto se puede coger al inventario 1 o no 0'
			),
			new OModelField(
				name: 'grabbable',
				type: OMODEL_BOOL,
				comment: 'Indica si el objeto se puede levantar 1 o no 0'
			),
			new OModelField(
				name: 'breakable',
				type: OMODEL_BOOL,
				comment: 'Indica si el objeto se puede romper 1 o no 0'
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
		$asset = new Asset();
		$asset->find(['id' => $this->get('id_asset')]);
		$this->setAsset($asset);
	}

	private ?Asset $asset_active = null;

	/**
	 * Obtiene el recurso usado para el objeto de escenario una vez activado
	 *
	 * @return Asset Recurso usado para el objeto de escenario una vez activado
	 */
	public function getAssetActive(): ?Asset {
		if (is_null($this->asset_active) && !is_null($this->get('id_asset_active'))) {
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
		$asset_active = new Asset();
		$asset_active->find(['id' => $this->get('id_asset_active')]);
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
		$sql = "SELECT * FROM `scenario_object_drop` WHERE `id_scenario_object` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$drops = [];

		while ($res = $this->db->next()) {
			$scenario_object_drop = new ScenarioObjectDrop();
			$scenario_object_drop->update($res);
			array_push($drops, $scenario_object_drop);
		}

		$this->setDrops($drops);
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
		$sql = "SELECT * FROM `scenario_object_frame` WHERE `id_scenario_object` = ? ORDER BY `order`";
		$this->db->query($sql, [$this->get('id')]);
		$frames = [];

		while ($res = $this->db->next()) {
			$scenario_object_frame = new ScenarioObjectFrame();
			$scenario_object_frame->update($res);
			array_push($frames, $scenario_object_frame);
		}

		$this->setFrames($frames);
	}
}
