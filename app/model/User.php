<?php declare(strict_types=1);
class User extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'user';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único de cada usuario'
			],
			'email' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Email del usuario'
			],
			'pass' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Contraseña del usuario'
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
	 * Comprueba si un usuario puede iniciar sesión
	 *
	 * @param string $email Email del usuario
	 *
	 * @param string $pass Contraseña del usuario
	 *
	 * @return bool Devuelve si el usuario puede iniciar sesión
	 */
	public function login(string $email, string $pass): bool {
		$ret = false;
		if ($this->find(array('email'=>$email))) {
			if ($this->get('pass')==sha1('gam_'.$pass.'_gam')) {
				$ret = true;
			}
		}
		return $ret;
	}

	private ?array $games = null;

	/**
	 * Guarda la lista de partidas del usuario
	 *
	 * @param array $g Lista de partidas
	 *
	 * @return void
	 */
	public function setGames(array $g): void {
		$this->games = $g;
	}

	/**
	 * Obtiene la lista de partidas del usuario
	 *
	 * @return array Lista de partidas del usuario
	 */
	public function getGames(): array {
		if (is_null($this->games)) {
			$this->loadGames();
		}
		return $this->games;
	}

	/**
	 * Carga la lista de partidas del usuario
	 *
	 * @return void
	 */
	public function loadGames(): void {
		$sql = "SELECT * FROM `game` WHERE `id_user` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res=$this->db->next()) {
			$gam = new Game();
			$gam->update($res);

			array_push($list, $gam);
		}

		$this->setGames($list);
	}

	/**
	 * Borra un usuario con todas sus partidas
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$games = $this->getGames();
		foreach ($games as $gam) {
			$gam->delete();
		}
		$this->delete();
	}
}