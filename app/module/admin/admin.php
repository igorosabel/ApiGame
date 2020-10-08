<?php declare(strict_types=1);
class admin extends OModule {
	private ?adminService $admin_service = null;
	private ?webService $web_service = null;

	function __construct() {
		$this->admin_service = new adminService();
		$this->web_service = new webService();
	}

	/**
	 * Función para iniciar sesión en el admin
	 *
	 * @url /admin/login
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function login(ORequest $req): void {
		$status = 'ok';
		$id = -1;
		$name = $req->getParamString('name');
		$pass = $req->getParamString('pass');
		$token = '';

		if (is_null($name) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			if ($name!='admin' || $pass!=$this->getConfig()->getExtra('admin_pass')) {
				$status = 'error';
			}
			else {
				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',   $id);
				$tk->addParam('name', $name);
				$tk->addParam('admin', true);
				$tk->addParam('exp', mktime() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id', $id);
		$this->getTemplate()->add('name', $name);
		$this->getTemplate()->add('token', $token);
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
		$word_one = $req->getParamString('wordOne');
		$word_two = $req->getParamString('wordTwo');
		$word_three = $req->getParamString('wordThree');
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
		$id_world = $req->getParamInt('idWorld');
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
	 * Página con el listado de fondos
	 *
	 * @url /admin/resources/backgrounds
	 * @filter adminFilter
	 * @type html
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function backgrounds(ORequest $req): void {
		$background_categories = $this->admin_service->getBackgroundCategories();
		$this->getTemplate()->addCss('admin');
		$this->getTemplate()->addComponent('background_categories', 'admin/background_category_select', ['list' => $background_categories]);
	}

	/**
	 * Función para obtener la lista de recursos
	 *
	 * @url /admin/asset-list
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function assetList(ORequest $req): void {
		$status = 'ok';
		$assets = $this->admin_service->getAssets();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'admin/assets', ['list' => $assets, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un recurso
	 *
	 * @url /admin/save-asset
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveAsset(ORequest $req): void {
		$status = 'ok';
		$id = $req->getParamInt('id');
		$id_world = $req->getParamInt('id_world');
		$name = $req->getParamString('name');
		$url = $req->getParamString('url');
		$tags = $req->getParamString('tagList');

		if (is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$ext = null;
			$asset = new Asset();
			if (!is_null($id)) {
				$asset->find(['id'=>$id]);
				$ext = $asset->get('ext');
			}
			if (!is_null($url)) {
				$ext = $this->admin_service->getFileExt($url);
			}
			$asset->set('id_world', $id_world);
			$asset->set('name', $name);
			$asset->set('ext', $ext);
			$asset->save();

			if (!is_null($url)) {
				$this->admin_service->saveAssetImage($asset, $url);
			}

			if (!is_null($tags) && $tags!='') {
				$this->admin_service->updateAssetTags($asset, $tags);
			}
			else {
				$this->admin_service->cleanAssetTags($asset);
				$this->admin_service->cleanUnnusedTags();
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un recurso
	 *
	 * @url /admin/delete-asset
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteAsset(ORequest $req): void {
		$status = 'ok';
		$id = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$return = $this->admin_service->deleteAsset($id);
			$status = $return['status'];
			$message = $return['message'];
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('message', $message);
	}

	/**
	 * Función para obtener la lista de tags
	 *
	 * @url /admin/tag-list
	 * @type json
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function tagList(ORequest $req): void {
		$status = 'ok';
		$tags   = $this->admin_service->getTags();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'admin/tags', ['list' => $tags, 'extra' => 'nourlencode']);
	}
}