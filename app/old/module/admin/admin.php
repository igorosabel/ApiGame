<?php declare(strict_types=1);
class admin extends OModule {
	public ?adminService $admin_service = null;
	public ?webService   $web_service   = null;

	function __construct() {
		$this->admin_service = new adminService();
		$this->web_service   = new webService();
	}

	/**
	 * Inicio de sesión en panel admin
	 *
	 * @url /admin
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function index(ORequest $req): void {
	    $msg = '';
	    if ($this->getSession()->getParam('admin_error')) {
	      $msg = 'El nombre de usuario o contraseña no son correctos.';
	      $this->getSession()->removeParam('admin_error');
	    }

	    $this->getTemplate()->add('msg', $msg);
	    $this->getTemplate()->addCss('home');
	}

	/**
	 * Función para iniciar sesión en el panel admin
	 *
	 * @url /admin/login
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function login(ORequest $req): void {
	    $status = 'ok';
	    $user = $req->getParamString('user');
	    $pass = $req->getParamString('pass');

	    if (is_null($user) || is_null($pass)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      if ($user=='admin' && $pass==$this->getConfig()->getExtra('admin_pass')) {
	        $status = 'ok';
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    if ($status=='ok') {
	      $this->getSession()->addParam('admin', true);
	      header('Location:'.OUrl::generateUrl('admin', 'main'));
	    }
	    else {
	      $this->getSession()->addParam('admin_error', true);
	      header('Location:'.OUrl::generateUrl('admin', 'index'));
	    }
	}

	/**
	 * Página inicial en el panel admin
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
	 * Página para editar escenarios
	 *
	 * @url /admin/scenarios
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function scenarios(ORequest $req): void {
		$scenarios = $this->admin_service->getScenarios();

	    $this->getTemplate()->addCss('admin');
	    $this->getTemplate()->addComponent('scenarios', 'admin/scenarios', ['scenarios' => $scenarios]);
	}

	/**
	 * Página para editar un escenario
	 *
	 * @url /edit-scenario/:id/:slug
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function editScenario(ORequest $req): void {
		$scn = new Scenario();
	    $scn->find(['id'=>$req->getParamInt('id')]);

	    $scenario = [
	      'id' => $scn->get('id'),
	      'name' => $scn->get('name'),
	      'data' => json_decode($scn->get('data'),true),
	      'start_x' => $scn->get('start_x'),
	      'start_y' => $scn->get('start_y'),
	      'initial' => $scn->get('initial')
	  ];

	    $backgrounds  = $this->web_service->getBackgrounds();
	    $sprites      = $this->web_service->getSprites();
	    $interactives = $this->web_service->getInteractives();

	    $this->getTemplate()->addComponent('backgrounds_css', 'public/backgrounds_css', ['backgrounds' => $backgrounds]);
	    $this->getTemplate()->addComponent('sprites_css',     'public/sprites_css',     ['sprites' => $sprites]);
	    $this->getTemplate()->add('scenario', json_encode($scenario));
	    $this->getTemplate()->addComponent('backgrounds', 'admin/backgrounds', ['backgrounds' => $backgrounds]);
	    $this->getTemplate()->add('bcks_data', json_encode($this->web_service->getBackgroundsData($backgrounds)));
	    $this->getTemplate()->addComponent('sprites', 'admin/sprites', ['sprites' => $sprites]);
	    $this->getTemplate()->add('sprs_data', json_encode($this->web_service->getSpritesData($sprites)));
	    $this->getTemplate()->addComponent('interactives', 'admin/interactives', ['interactives' => $interactives]);
	    $this->getTemplate()->add('ints_data', json_encode($this->web_service->getInteractivesData($interactives)));

	    $this->getTemplate()->setTitle('Game - '.$scn->get('name'));
	    $this->getTemplate()->addCss('admin');
	    $this->getTemplate()->addCss('game');
	}

	/**
	 * Página para editar los fondos
	 *
	 * @url /admin/backgrounds
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function backgrounds(ORequest $req): void {
		$backgrounds = $this->web_service->getBackgrounds();

	    $this->getTemplate()->addCss('admin');
	    $this->getTemplate()->addCss('game');
	    $this->getTemplate()->addComponent('backgrounds_css', 'public/backgrounds_css', ['backgrounds' => $backgrounds]);
	    $this->getTemplate()->addComponent('backgrounds',     'admin/backgrounds_edit', ['backgrounds' => $backgrounds]);
	}

	/**
	 * Página para editar los sprites
	 *
	 * @url /admin/sprites
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function sprites(ORequest $req): void {
		$sprites = $this->web_service->getSprites();

	    $this->getTemplate()->addCss('admin');
	    $this->getTemplate()->addComponent('sprites_css', 'public/sprites_css', ['sprites' => $sprites]);
	    $this->getTemplate()->addComponent('sprites',     'admin/sprites_edit', ['sprites' => $sprites]);
	}

	/**
	 * Página para editar los elementos interactivos
	 *
	 * @url /admin/interactives
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function interactives(ORequest $req): void {
		$interactives = $this->web_service->getInteractives();
	    $sprites      = $this->web_service->getSprites();

	    $pickables = [];
	    foreach ($interactives as $int) {
	      if ($int->get('pickable')) {
	        array_push($pickables, $int);
	      }
	    }

	    $this->getTemplate()->addCss('admin');
	    $this->getTemplate()->addComponent('interactives',      'admin/interactives_edit', ['interactives' => $interactives]);
	    $this->getTemplate()->addComponent('interactives_json', 'admin/interactives_json', ['pickables' => $pickables]);
	    $this->getTemplate()->addComponent('sprites_css',       'public/sprites_css',      ['sprites' => $sprites]);
	    $this->getTemplate()->addComponent('sprites',           'admin/sprites',           ['sprites' => $sprites]);
	    $this->getTemplate()->addComponent('sprites_json',      'admin/sprites_json',      ['sprites' => $sprites]);
	}

	/**
	 * Página para editar los usuarios
	 *
	 * @url /admin/users
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function users(ORequest $req): void {
		$users = $this->admin_service->getUsers();
	    $scenarios = $this->admin_service->getScenarios();

	    $this->getTemplate()->addCss('admin');
	    $this->getTemplate()->addComponent('users',     'admin/users_edit',      array('users'=>$users));
	    $this->getTemplate()->addComponent('scenarios', 'admin/scenarios_users', array('scenarios'=>$scenarios));
	}
}