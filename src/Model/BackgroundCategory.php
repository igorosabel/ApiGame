<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Background;

class BackgroundCategory extends OModel {
	#[OPK(
	  comment: 'Id único de cada categoría'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Nombre de la categoría',
	  nullable: false,
	  max: 50
	)]
	public ?string $name;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$list = Background::where(['id_background_category' => $this->id], ['order_by' => 'name']);
		$this->setBackgrounds($list);
	}
}
