<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;
use Osumi\OsumiFramework\App\Model\Background;

class BackgroundCategory extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único de cada categoría'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: 'null',
				size: 50,
				comment: 'Nombre de la categoría'
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

	private ?array $backgrounds = null;

	/**
	 * Obtiene la lista de fondos de una categoría
	 *
	 * @return array Lista de fondos de una categoría
	 */
	public function getBackgrounds(): array {
		if (is_null($this->backgrounds)) {
			$this->loadBackgrounds();
		}
		return $this->backgrounds;
	}

	/**
	 * Guarda la lista de fondos de una categoría
	 *
	 * @param array $backgrounds Lista de fondos de una categoría
	 *
	 * @return void
	 */
	public function setBackgrounds(array $backgrounds): void {
		$this->backgrounds = $backgrounds;
	}

	/**
	 * Carga la lista de fondos de una categoría
	 *
	 * @return void
	 */
	public function loadBackgrounds(): void {
		$sql = "SELECT * FROM `background` WHERE `id_background_category` = ? ORDER BY `name`";
		$this->db->query($sql, [$this->get('id')]);
		$backgrounds = [];

		while ($res = $this->db->next()) {
			$background = new Background();
			$background->update($res);
			array_push($backgrounds, $background);
		}

		$this->setBackgrounds($backgrounds);
	}
}
