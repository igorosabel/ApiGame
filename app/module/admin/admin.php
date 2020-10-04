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
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function logout(ORequest $req): void {
		$this->getSession()->removeParam('admin_login');
		header('location: /admin');
		exit;
	}
}