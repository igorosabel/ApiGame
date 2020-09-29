<?php declare(strict_types=1);
class Character extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'character';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada tipo de personaje'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Nombre del tipo de personaje'
			],
			'slug' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Slug del nombre del tipo de personaje'
			],
			'file_up' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Imagen del personaje al mirar hacia arriba'
			],
			'file_down' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Imagen del personaje al mirar hacia abajo'
			],
			'file_left' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Imagen del personaje al mirar hacia la izquierda'
			],
			'file_right' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Imagen del personaje al mirar hacia la derecha'
			],
			'is_npc' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el tipo de personaje es un NPC'
			],
			'is_enemy' => [
				'type'    => OCore::BOOL,
				'nullable' => false,
				'default' => true,
				'comment' => 'Indica si el tipo de personaje es un enemigo'
			],
			'health' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Salud del tipo de personaje'
			],
			'attack' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Daño que hace el tipo de personaje'
			],
			'speed' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Velocidad el tipo de personaje'
			],
			'drops' => [
				'type'    => OCore::NUM,
				'nullable' => true,
				'default' => null,
				'comment' => 'Id del elemento que da el tipo de personaje'
			],
			'created_at' => [
				'type'    => OCore::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OCore::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($table_name, $model);
	}

	/**
	 * Borra un personaje con todos sus frames e imágenes
	 *
	 * @return void
	 */
	public function deleteFull(): void {
	  global $core;

	  $frames = $this->getFrames();
	  foreach ($frames as $fr) {
		$fr->setCharacter($this);
		$fr->deleteFull();
	  }

	  $ruta_up = $core->config->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_up').'.png';
	  if (file_exists($ruta_up)) {
		unlink($ruta_up);
	  }
	  $ruta_down = $core->config->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_down').'.png';
	  if (file_exists($ruta_down)) {
		unlink($ruta_down);
	  }
	  $ruta_left = $core->config->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_left').'.png';
	  if (file_exists($ruta_left)) {
		unlink($ruta_left);
	  }
	  $ruta_right = $core->config->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_right').'.png';
	  if (file_exists($ruta_right)) {
		unlink($ruta_right);
	  }

	  $this->delete();
	}

	private ?array $frames = null;

	/**
	 * Devuelve la lista de frames del personaje
	 *
	 * @return array Lista de frames
	 */
	public function getFrames(): array {
	  if (is_null($this->frames)) {
		$this->loadFrames();
	  }
	  return $this->frames;
	}

	/**
	 * Carga la lista de frames del personaje
	 *
	 * @return void
	 */
	public function loadFrames(): void {
	  $list = [];
	  $sql = "SELECT * FROM `character_frame` WHERE `id_character` = ? ORDER BY `order`";
	  $this->db->query($sql, [$this->get('id')]);
	  while ($res=$this->db->next()) {
		$charf = new CharacterFrame();
		$charf->update($res);
		array_push($list, $charf);
	  }
	  $this->frames = $list;
	}
}