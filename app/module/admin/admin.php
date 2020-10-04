<?php declare(strict_types=1);
class admin extends OModule {
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
	 * Nueva acción logout
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
	 * Nueva acción worlds
	 *
	 * @url /admin/worlds
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function worlds(ORequest $req): void {}

	/**
	 * Nueva acción scenarios
	 *
	 * @url /admin/world/:id_world/scenarios
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function scenarios(ORequest $req): void {}

	/**
	 * Nueva acción editScenario
	 *
	 * @url /admin/world/:id_world/scenario/:id_scenario
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function editScenario(ORequest $req): void {}

	/**
	 * Nueva acción resources
	 *
	 * @url /admin/resources
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function resources(ORequest $req): void {}

	/**
	 * Nueva acción backgrounds
	 *
	 * @url /admin/resources/backgrounds
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function backgrounds(ORequest $req): void {}

	/**
	 * Nueva acción backgroundCategories
	 *
	 * @url /admin/resources/backgrounds/categories
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function backgroundCategories(ORequest $req): void {}

	/**
	 * Nueva acción characters
	 *
	 * @url /admin/resources/characters
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function characters(ORequest $req): void {}

	/**
	 * Nueva acción scenarioObjects
	 *
	 * @url /admin/resources/scenario-objects
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function scenarioObjects(ORequest $req): void {}

	/**
	 * Nueva acción items
	 *
	 * @url /admin/resources/items
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function items(ORequest $req): void {}

	/**
	 * Nueva acción assets
	 *
	 * @url /admin/resources/assets
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function assets(ORequest $req): void {}

	/**
	 * Nueva acción users
	 *
	 * @url /admin/users
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function users(ORequest $req): void {}

	/**
	 * Nueva acción userGames
	 *
	 * @url /admin/user/:id_user/games
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function userGames(ORequest $req): void {}
}