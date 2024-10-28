<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;
use Osumi\OsumiFramework\App\Model\Tag;

class Asset extends OModel {
	#[OPK(
	  comment: 'Id único de cada recurso'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del mundo en el que se usa el recurso o NULL si sirve para todos',
	  nullable: true,
	  ref: 'world.id',
	  default: null
	)]
	public ?int $id_world;

	#[OField(
	  comment: 'Nombre del recurso',
	  nullable: false,
	  max: 50,
	  default: 'null'
	)]
	public ?string $name;

	#[OField(
	  comment: 'Extensión del archivo del recurso',
	  nullable: false,
	  max: 5,
	  default: 'null'
	)]
	public ?string $ext;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	/**
	 * Función para obtener la URL al recurso
	 *
	 * @return string URL del recurso
	 */
	public function getUrl(): string {
		global $core;
		return $core->config->getUrl('base') . '/assets/' . $this->id . '.' . $this->ext;
	}

	/**
	 * Función para obtener la ruta física al archivo del recurso
	 *
	 * @return string Ruta al archivo
	 */
	public function getFile(): string {
		global $core;
		return $core->config->getDir('assets') . $this->id . '.' . $this->ext;
	}

	private ?array $tags = null;

	/**
	 * Obtiene la lista de tags del recurso
	 *
	 * @return array Lista de tags
	 */
	public function getTags(): array {
		if (is_null($this->tags)) {
			$this->loadTags();
		}
		return $this->tags;
	}

	/**
	 * Guarda la lista de tags
	 *
	 * @param array $tags Lista de tags
	 *
	 * @return void
	 */
	public function setTags(array $tags):  void {
		$this->tags = $tags;
	}

	/**
	 * Carga la lista de tags
	 *
	 * @return void
	 */
	public function loadTags(): void {
		$db = new ODB();
		$sql = "SELECT * FROM `tag` WHERE `id` IN (SELECT `id_tag` FROM `asset_tag` WHERE `id_asset` = ?)";
		$db->query($sql, [$this->id]);
		$list = [];

		while ($res = $db->next()) {
			$tag = Tag::from($res);
			$list[] = $tag;
		}

		$this->setTags($list);
	}

	/**
	 * Obtiene la lista de tags como una cadena de texto
	 *
	 * @return string Lista de tags como una cadena de texto
	 */
	public function getTagsAsString(): string {
		$list = $this->getTags();
		$tags = [];
		foreach ($list as $tag) {
			$tags[] = $tag->get('name');
		}

		return implode(', ', $tags);
	}

	/**
	 * Función para borrar un recurso junto a su imagen
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$route = $this->getFile();
		if (file_exists($route)) {
			unlink($route);
		}
		$this->delete();
	}
}
