<?php declare(strict_types=1);
class admin extends OModule {
	private ?adminService $admin_service = null;
	private ?webService $web_service = null;

	function __construct() {
		$this->admin_service = new adminService();
		$this->web_service = new webService();
	}

	/**
	 * Pantalla para iniciar sesión en el admin
	 *
	 * @url /admin
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function index(ORequest $req): void {
		$errormsg = 'hide';
		if (!is_null($this->getSession()->getParam('error-msg'))) {
			$errormsg = 'show';
			$this->getSession()->removeParam('error-msg');
		}
		$this->getTemplate()->addCss('admin');
		$this->getTemplate()->add('errormsg', $errormsg);
	}

	/**
	 * Función para iniciar sesión en el admin
	 *
	 * @url /admin/login
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function login(ORequest $req): void {
		$status = 'ok';
		$name = $req->getParamString('login-name');
		$pass = $req->getParamString('login-password');

		if (is_null($name) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			if ($name!='admin' || $pass!=$this->getConfig()->getExtra('admin_pass')) {
				$status = 'error';
			}
		}

		if ($status=='ok') {
			$this->getSession()->addParam('admin_login', true);
			header('location: /admin/main');
		}
		else {
			$this->getSession()->addParam('error-msg', true);
			header('location: /admin');
		}
		exit;
	}

	/**
	 * Pantalla principal del admin
	 *
	 * @url /admin/main
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function main(ORequest $req): void {
		$this->getTemplate()->addCss('admin');
	}

	/**
	 * Función para cerrar sesión del admin
	 *
	 * @url /admin/logout
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function logout(ORequest $req): void {
		$this->getSession()->removeParam('admin_login');
		header('location: /admin');
		exit;
	}

	/**
	 * Página con el listado de mundos
	 *
	 * @url /admin/worlds
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function worlds(ORequest $req): void {
		$this->getTemplate()->addCss('admin');
	}

	/**
	 * Función para obtener la lista de mundos
	 *
	 * @url /admin/world-list
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function worldList(ORequest $req): void {
		$list = $this->admin_service->getWorlds();
		$this->getTemplate()->addComponent('list', 'admin/worlds', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un mundo
	 *
	 * @url /admin/save-world
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveWorld(ORequest $req): void {
		$status = 'ok';
		$id = $req->getParamInt('id');
		$name = $req->getParamString('name');
		$description = $req->getParamString('description');
		$word_one = $req->getParamString('word_one');
		$word_two = $req->getParamString('word_two');
		$word_three = $req->getParamString('word_three');
		$friendly = $req->getParamBool('friendly');

		if (is_null($name) || is_null($word_one) || is_null($word_two) || is_null($word_three) || is_null($friendly)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$world = new World();
			if (!is_null($id)) {
				$world->find(['id'=>$id]);
			}
			$world->set('name', $name);
			$world->set('description', $description);
			$world->set('word_one', $word_one);
			$world->set('word_two', $word_two);
			$world->set('word_three', $word_three);
			$world->set('friendly', $friendly);
			$world->save();
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un mundo
	 *
	 * @url /admin/delete-world
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteWorld(ORequest $req): void {
		$status = 'ok';
		$id = $req->getParamInt('id');

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$world = new World();
			if ($world->find(['id'=>$id])) {
				$origin_world = $this->web_service->getOriginWorld();
				$this->admin_service->deleteWorld($world, $origin_world);
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Página con el listado de escenarios de un mundo
	 *
	 * @url /admin/world/:id_world/scenarios
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function scenarios(ORequest $req): void {
		$id = $req->getParamInt('id_world');
		$world = new World();
		$world->find(['id'=>$id]);
		$scenarios = $world->getScenarios();

		$this->getTemplate()->addCss('admin');
		$this->getTemplate()->add('worldId', $id);
		$this->getTemplate()->addComponent('list', 'admin/scenarios', ['list' => $scenarios]);
	}

	/**
	 * Función para obtener la lista de escenarios
	 *
	 * @url /admin/scenario-list
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function scenarioList(ORequest $req): void {
		$status = 'ok';
		$id = $req->getParamInt('id');
		$list = [];

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$list = $this->admin_service->getScenarios($id);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'admin/scenarios', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un escenario
	 *
	 * @url /admin/save-scenario
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveScenario(ORequest $req): void {
		$status = 'ok';
		$id = $req->getParamInt('id');
		$id_world = $req->getParamInt('id_world');
		$name = $req->getParamString('name');
		$friendly = $req->getParamBool('friendly');

		if (is_null($name) || is_null($id_world) || is_null($friendly)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if (!is_null($id)) {
				$scenario->find(['id'=>$id]);
			}
			$scenario->set('id_world', $id_world);
			$scenario->set('name', $name);
			$scenario->set('friendly', $friendly);

			$scenario->save();
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un mundo
	 *
	 * @url /admin/delete-scenario
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteScenario(ORequest $req): void {
		$status = 'ok';
		$id = $req->getParamInt('id');

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if ($scenario->find(['id'=>$id])) {
				$origin_world = $this->web_service->getOriginWorld();
				$this->admin_service->deleteScenario($scenario, $origin_world);
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Página para editar un escenario
	 *
	 * @url /admin/world/:id_world/scenario/:id_scenario
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function editScenario(ORequest $req): void {}

	/**
	 * Página principal de recursos
	 *
	 * @url /admin/resources
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function resources(ORequest $req): void {}

	/**
	 * Página con el listado de fondos
	 *
	 * @url /admin/resources/backgrounds
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function backgrounds(ORequest $req): void {}

	/**
	 * Página con el listado de categorías de fondos
	 *
	 * @url /admin/resources/backgrounds/categories
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function backgroundCategories(ORequest $req): void {}

	/**
	 * Página con el listado de personajes
	 *
	 * @url /admin/resources/characters
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function characters(ORequest $req): void {}

	/**
	 * Página con el listado de objetos de escenario
	 *
	 * @url /admin/resources/scenario-objects
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function scenarioObjects(ORequest $req): void {}

	/**
	 * Página con el listado de items
	 *
	 * @url /admin/resources/items
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function items(ORequest $req): void {}

	/**
	 * Página con el listado de recursos
	 *
	 * @url /admin/resources/assets
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function assets(ORequest $req): void {}

	/**
	 * Página con el listado de usuarios
	 *
	 * @url /admin/users
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function users(ORequest $req): void {}

	/**
	 * Página con el listado de partidas y detalle de un jugador
	 *
	 * @url /admin/user/:id_user/games
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function userGames(ORequest $req): void {}
}