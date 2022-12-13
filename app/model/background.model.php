<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Background extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único de cada fondo'
			),
			new OModelField(
				name: 'id_background_category',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'background_category.id',
				comment: 'Id de la categoría a la que pertenece'
			),
			new OModelField(
				name: 'id_asset',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'asset.id',
				comment: 'Id del recurso que se utiliza para el fondo'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 50,
				comment: 'Nombre del fondo'
			),
			new OModelField(
				name: 'crossable',
				type: OMODEL_BOOL,
				comment: 'Indica si la casilla se puede cruzar 1 o no 0'
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
		$asset = new Asset();
		$asset->find(['id' => $this->get('id_asset')]);
		$this->setAsset($asset);
	}
}
