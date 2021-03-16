<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Core\OModule;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Routing\ORoute;
use OsumiFramework\App\Model\Background;
use OsumiFramework\App\Model\ScenarioObject;
use OsumiFramework\App\Model\Character;
use OsumiFramework\App\Model\Item;
use OsumiFramework\App\Model\BackgroundCategory;
use OsumiFramework\App\Model\User;
use OsumiFramework\App\Model\Scenario;
use OsumiFramework\App\Model\ScenarioData;
use OsumiFramework\App\Model\World;
use OsumiFramework\App\Model\Asset;
use OsumiFramework\App\Service\webService;
use OsumiFramework\App\Service\adminService;
use OsumiFramework\OFW\Plugins\OToken;

#[ORoute(
	type: 'json',
	prefix: '/admin'
)]
class admin extends OModule {
	private ?adminService $admin_service = null;
	private ?webService   $web_service   = null;

	function __construct() {
		$this->admin_service = new adminService();
		$this->web_service   = new webService();
	}

	/**
	 * Función para iniciar sesión en el admin
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/login')]
	public function login(ORequest $req): void {
		$status = 'ok';
		$id     = -1;
		$email  = $req->getParamString('email');
		$pass   = $req->getParamString('pass');
		$token  = '';

		if (is_null($email) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$user = new User();
			if ($user->login($email, $pass) && $user->get('admin')) {
				$id = $user->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('email', $email);
				$tk->addParam('admin', true);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
	}

	/**
	 * Función para obtener la lista de mundos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/world-list',
		filter: 'adminFilter'
	)]
	public function worldList(ORequest $req): void {
		$list = $this->admin_service->getWorlds();
		$this->getTemplate()->addComponent('list', 'model/worlds', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un mundo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-world',
		filter: 'adminFilter'
	)]
	public function saveWorld(ORequest $req): void {
		$status      = 'ok';
		$id          = $req->getParamInt('id');
		$name        = $req->getParamString('name');
		$description = $req->getParamString('description');
		$word_one    = $req->getParamString('wordOne');
		$word_two    = $req->getParamString('wordTwo');
		$word_three  = $req->getParamString('wordThree');
		$friendly    = $req->getParamBool('friendly');

		if (is_null($name) || is_null($word_one) || is_null($word_two) || is_null($word_three) || is_null($friendly)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$world = new World();
			if (!is_null($id)) {
				$world->find(['id' => $id]);
			}
			$world->set('name',        $name);
			$world->set('description', $description);
			$world->set('word_one',    $word_one);
			$world->set('word_two',    $word_two);
			$world->set('word_three',  $word_three);
			$world->set('friendly',    $friendly);
			$world->save();
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un mundo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-world',
		filter: 'adminFilter'
	)]
	public function deleteWorld(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$world = new World();
			if ($world->find(['id' => $id])) {
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
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/scenario-list',
		filter: 'adminFilter'
	)]
	public function scenarioList(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$list   = [];

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$list = $this->admin_service->getScenarios($id);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/scenarios', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-scenario',
		filter: 'adminFilter'
	)]
	public function saveScenario(ORequest $req): void {
		$status   = 'ok';
		$id       = $req->getParamInt('id');
		$id_world = $req->getParamInt('idWorld');
		$name     = $req->getParamString('name');
		$friendly = $req->getParamBool('friendly');

		if (is_null($name) || is_null($id_world) || is_null($friendly)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if (!is_null($id)) {
				$scenario->find(['id' => $id]);
			}
			$scenario->set('id_world', $id_world);
			$scenario->set('name',     $name);
			$scenario->set('friendly', $friendly);

			$scenario->save();
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un mundo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-scenario',
		filter: 'adminFilter'
	)]
	public function deleteScenario(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id])) {
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
	 * Función para obtener el detalle de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/get-scenario',
		filter: 'adminFilter'
	)]
	public function getScenario(ORequest $req): void {
		$status     = 'ok';
		$id         = $req->getParamInt('id');
		$data       = [];
		$connection = [];

		$scenario = new Scenario();
		if ($scenario->find(['id' => $id])) {
			$data       = $scenario->getData();
			$connection = $scenario->getConnections();
		}
		else {
			$status = 'error';
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('scenario',   'model/scenario',       ['sce' => $scenario,    'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('data',       'model/scenario_datas', ['list' => $data,       'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('connection', 'model/connections',    ['list' => $connection, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar el detalle de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-scenario-data',
		filter: 'adminFilter'
	)]
	public function saveScenarioData(ORequest $req): void {
		$status             = 'ok';
		$id                 = $req->getParamInt('id');
		$id_scenario        = $req->getParamInt('idScenario');
		$x                  = $req->getParamInt('x');
		$y                  = $req->getParamInt('y');
		$id_background      = $req->getParamInt('idBackground');
		$id_scenario_object = $req->getParamInt('idScenarioObject');
		$id_character       = $req->getParamInt('idCharacter');
		$character_health   = $req->getParamInt('characterHealth');

		if (is_null($id_scenario) || is_null($x) || is_null($y)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario_data = new ScenarioData();
			if (!is_null($id)) {
				$scenario_data->find(['id' => $id]);
			}
			$scenario_data->set('id_scenario',        $id_scenario);
			$scenario_data->set('x',                  $x);
			$scenario_data->set('y',                  $y);
			$scenario_data->set('id_background',      $id_background);
			$scenario_data->set('id_scenario_object', $id_scenario_object);
			$scenario_data->set('id_character',       $id_character);
			$scenario_data->set('character_health',   $character_health);
			$scenario_data->save();

			$id = $scenario_data->get('id');
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
	}

	/**
	 * Función para guardar una conexión de un escenario a otro
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-connection',
		filter: 'adminFilter'
	)]
	public function saveConnection(ORequest $req): void {
		$status      = 'ok';
		$id_from     = $req->getParamInt('from');
		$id_to       = $req->getParamInt('to');
		$orientation = $req->getParamString('orientation');

		if (is_null($id_from) || is_null($id_to) || is_null($orientation)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$this->admin_service->updateConnection($id_from, $id_to, $orientation);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar una conexión de un escenario a otro
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-connection',
		filter: 'adminFilter'
	)]
	public function deleteConnection(ORequest $req): void {
		$status      = 'ok';
		$id_from     = $req->getParamInt('from');
		$id_to       = $req->getParamInt('to');
		$orientation = $req->getParamString('orientation');

		if (is_null($id_from) || is_null($id_to) || is_null($orientation)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$this->admin_service->deleteConnection($id_from, $id_to, $orientation);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar una conexión de un escenario a otro
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/select-world-start',
		filter: 'adminFilter'
	)]
	public function selectWorldStart(ORequest $req): void {
		$status      = 'ok';
		$id_scenario = $req->getParamInt('idScenario');
		$x           = $req->getParamInt('x');
		$y           = $req->getParamInt('y');
		$check       = $req->getParamBool('check');
		$message      = '';

		if (is_null($id_scenario) || is_null($x) || is_null($y) || is_null($check)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id_scenario])) {
				if ($check) {
					$result  = $this->admin_service->checkWorldStart($scenario);
					$status  = $result['status'];
					$message = $result['message'];
				}
				if ($status=='ok') {
					$this->admin_service->clearWorldStart($scenario);
					$scenario->set('start_x', $x);
					$scenario->set('start_y', $y);
					$scenario->set('initial', true);
					$scenario->save();
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}

	/**
	 * Función para generar el mapa de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/generate-map',
		filter: 'adminFilter'
	)]
	public function generateMap(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			OTools::runTask('map', [$id, 'true']);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para obtener la lista de recursos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/asset-list',
		filter: 'adminFilter'
	)]
	public function assetList(ORequest $req): void {
		$status = 'ok';
		$assets = $this->admin_service->getAssets();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/assets', ['list' => $assets, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un recurso
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-asset',
		filter: 'adminFilter'
	)]
	public function saveAsset(ORequest $req): void {
		$status   = 'ok';
		$id       = $req->getParamInt('id');
		$id_world = $req->getParamInt('id_world');
		$name     = $req->getParamString('name');
		$url      = $req->getParamString('url');
		$tags     = $req->getParamString('tagList');

		if (is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$ext = null;
			$asset = new Asset();
			if (!is_null($id)) {
				$asset->find(['id' => $id]);
				$ext = $asset->get('ext');
			}
			if (!is_null($url)) {
				$ext = $this->admin_service->getFileExt($url);
			}
			$asset->set('id_world', $id_world);
			$asset->set('name',     $name);
			$asset->set('ext',      $ext);
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
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-asset',
		filter: 'adminFilter'
	)]
	public function deleteAsset(ORequest $req): void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$return  = $this->admin_service->deleteAsset($id);
			$status  = $return['status'];
			$message = $return['message'];
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}

	/**
	 * Función para obtener la lista de tags
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/tag-list',
		filter: 'adminFilter'
	)]
	public function tagList(ORequest $req): void {
		$status = 'ok';
		$tags   = $this->admin_service->getTags();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/tags', ['list' => $tags, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para obtener la lista de categorías de fondos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/background-category-list',
		filter: 'adminFilter'
	)]
	public function backgroundCategoryList(ORequest $req): void {
		$status                = 'ok';
		$background_categories = $this->admin_service->getBackgroundCategories();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addModelComponentList('list', $background_categories, ['created_at', 'updated_at']);
	}

	/**
	 * Función para guardar una categoría de fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-background-category',
		filter: 'adminFilter'
	)]
	public function saveBackgroundCategory(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$name   = $req->getParamString('name');

		if (is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$background_category = new BackgroundCategory();
			if (!is_null($id)) {
				$background_category->find(['id' => $id]);
			}
			$background_category->set('name', $name);
			$background_category->save();
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar una categoría de fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-background-category',
		filter: 'adminFilter'
	)]
	public function deleteBackgroundCategory(ORequest $req): void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$background_category = new BackgroundCategory();
			if ($background_category->find(['id'=>$id])) {
				$return  = $this->admin_service->deleteBackgroundCategory($background_category);
				$status  = $return['status'];
				$message = $return['message'];
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}

	/**
	 * Función para obtener la lista de fondos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/background-list',
		filter: 'adminFilter'
	)]
	public function backgroundList(ORequest $req): void {
		$status      = 'ok';
		$backgrounds = $this->admin_service->getBackgrounds();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/backgrounds', ['list' => $backgrounds, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-background',
		filter: 'adminFilter'
	)]
	public function saveBackground(ORequest $req): void {
		$status                 = 'ok';
		$id                     = $req->getParamInt('id');
		$id_background_category = $req->getParamInt('idBackgroundCategory');
		$id_asset               = $req->getParamInt('idAsset');
		$name                   = $req->getParamString('name');
		$crossable              = $req->getParamBool('crossable');

		if (is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$background = new Background();
			if (!is_null($id)) {
				$background->find(['id'=>$id]);
			}
			$background->set('id_background_category', $id_background_category);
			$background->set('id_asset',               $id_asset);
			$background->set('name',                   $name);
			$background->set('crossable',              $crossable);
			$background->save();
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-background',
		filter: 'adminFilter'
	)]
	public function deleteBackground(ORequest $req): void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$background = new Background();
			if ($background->find(['id' => $id])) {
				$return = $this->admin_service->deleteBackground($background);
				$status  = $return['status'];
				$message = $return['message'];
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}

	/**
	 * Función para obtener la lista de items
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/item-list',
		filter: 'adminFilter'
	)]
	public function itemList(ORequest $req): void {
		$status = 'ok';
		$items  = $this->admin_service->getItems();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/items', ['list' => $items, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un item
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-item',
		filter: 'adminFilter'
	)]
	public function saveItem(ORequest $req): void {
		$status   = 'ok';
		$id       = $req->getParamInt('id');
		$type     = $req->getParamInt('type');
		$id_asset = $req->getParamInt('idAsset');
		$name     = $req->getParamString('name');
		$money    = $req->getParamInt('money');
		$health   = $req->getParamInt('health');
		$attack   = $req->getParamInt('attack');
		$defense  = $req->getParamInt('defense');
		$speed    = $req->getParamInt('speed');
		$wearable = $req->getParamInt('wearable');
		$frames   = $req->getParam('frames');

		if (is_null($name) || is_null($id_asset) || is_null($type)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$item = new Item();
			if (!is_null($id)) {
				$item->find(['id' => $id]);
			}
			$item->set('type',     $type);
			$item->set('id_asset', $id_asset);
			$item->set('name',     $name);
			$item->set('money',    $money);
			$item->set('health',   $health);
			$item->set('attack',   $attack);
			$item->set('defense',  $defense);
			$item->set('speed',    $speed);
			$item->set('wearable', $wearable);
			$item->save();

			$this->admin_service->updateItemFrames($item, $frames);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un item
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-item',
		filter: 'adminFilter'
	)]
	public function deleteItem(ORequest $req): void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$return  = $this->admin_service->deleteItem($id);
			$status  = $return['status'];
			$message = $return['message'];
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}

	/**
	 * Función para obtener la lista de personajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/character-list',
		filter: 'adminFilter'
	)]
	public function characterList(ORequest $req): void {
		$status = 'ok';
		$items  = $this->admin_service->getCharacters();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/characters', ['list' => $items, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un personaje
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-character',
		filter: 'adminFilter'
	)]
	public function saveCharacter(ORequest $req): void {
		$status         = 'ok';
		$id             = $req->getParamInt('id');
		$type           = $req->getParamInt('type');
		$fixed_position = $req->getParamBool('fixedPosition');
		$id_asset_up    = $req->getParamInt('idAssetUp');
		$id_asset_down  = $req->getParamInt('idAssetDown');
		$id_asset_left  = $req->getParamInt('idAssetLeft');
		$id_asset_right = $req->getParamInt('idAssetRight');
		$name           = $req->getParamString('name');
		$width          = $req->getParamInt('width');
		$block_width    = $req->getParamInt('blockWidth');
		$height         = $req->getParamInt('height');
		$block_height   = $req->getParamInt('blockHeight');
		$health         = $req->getParamInt('health');
		$attack         = $req->getParamInt('attack');
		$defense        = $req->getParamInt('defense');
		$speed          = $req->getParamInt('speed');
		$drop_id_item   = $req->getParamInt('dropIdItem');
		$drop_chance    = $req->getParamInt('dropChance');
		$respawn        = $req->getParamInt('respawn');
		$framesUp       = $req->getParam('framesUp');
		$framesDown     = $req->getParam('framesDown');
		$framesLeft     = $req->getParam('framesLeft');
		$framesRight    = $req->getParam('framesRight');
		$narratives     = $req->getParam('narratives');

		if (is_null($name) || is_null($type) || is_null($width) || is_null($height)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$character = new Character();
			if (!is_null($id)) {
				$character->find(['id' => $id]);
			}
			$character->set('type',           $type);
			$character->set('fixed_position', $fixed_position);
			$character->set('id_asset_up',    $id_asset_up);
			$character->set('id_asset_down',  $id_asset_down);
			$character->set('id_asset_left',  $id_asset_left);
			$character->set('id_asset_right', $id_asset_right);
			$character->set('name',           $name);
			$character->set('width',          $width);
			$character->set('blockWidth',     $block_width);
			$character->set('height',         $height);
			$character->set('block_height',   $block_height);
			$character->set('health',         $health);
			$character->set('attack',         $attack);
			$character->set('defense',        $defense);
			$character->set('speed',          $speed);
			$character->set('drop_id_item',   $drop_id_item);
			$character->set('drop_chance',    $drop_chance);
			$character->set('respawn',        $respawn);
			$character->save();

			$this->admin_service->updateCharacterFrames($character, $framesUp,    'up');
			$this->admin_service->updateCharacterFrames($character, $framesDown,  'down');
			$this->admin_service->updateCharacterFrames($character, $framesLeft,  'left');
			$this->admin_service->updateCharacterFrames($character, $framesRight, 'right');
			$this->admin_service->updateCharacterNarratives($character, $narratives);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un personaje
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-character',
		filter: 'adminFilter'
	)]
	public function deleteCharacter(ORequest $req): void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$return  = $this->admin_service->deleteCharacter($id);
			$status  = $return['status'];
			$message = $return['message'];
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}

	/**
	 * Función para obtener la lista de objetos de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/scenario-object-list',
		filter: 'adminFilter'
	)]
	public function scenarioObjectList(ORequest $req): void {
		$status = 'ok';
		$items  = $this->admin_service->getScenarioObjects();

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/scenario_objects', ['list' => $items, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un objeto de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/save-scenario-object',
		filter: 'adminFilter'
	)]
	public function saveScenarioObject(ORequest $req): void {
		$status                = 'ok';
		$id                    = $req->getParamInt('id');
		$name                  = $req->getParamString('name');
		$id_asset              = $req->getParamInt('idAsset');
		$width                 = $req->getParamInt('width');
		$block_width           = $req->getParamInt('blockWidth');
		$height                = $req->getParamInt('height');
		$block_height          = $req->getParamInt('blockHeight');
		$crossable             = $req->getParamBool('crossable');
		$activable             = $req->getParamBool('activable');
		$id_asset_active       = $req->getParamInt('idAssetActive');
		$active_time           = $req->getParamInt('activeTime');
		$active_trigger        = $req->getParamInt('activeTrigger');
		$active_trigger_custom = $req->getParamString('activeTriggerCustom');
		$pickable              = $req->getParamBool('pickable');
		$grabbable             = $req->getParamBool('grabbable');
		$breakable             = $req->getParamBool('breakable');
		$drops                 = $req->getParam('drops');
		$frames                = $req->getParam('frames');

		if (is_null($name) || is_null($id_asset) || is_null($width) || is_null($height)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario_object = new ScenarioObject();
			if (!is_null($id)) {
				$scenario_object->find(['id' => $id]);
			}
			$scenario_object->set('name',                  $name);
			$scenario_object->set('id_asset',              $id_asset);
			$scenario_object->set('width',                 $width);
			$scenario_object->set('block_width',           $block_width);
			$scenario_object->set('height',                $height);
			$scenario_object->set('block_height',          $block_height);
			$scenario_object->set('crossable',             $crossable);
			$scenario_object->set('activable',             $activable);
			$scenario_object->set('id_asset_active',       $id_asset_active);
			$scenario_object->set('active_time',           $active_time);
			$scenario_object->set('active_trigger',        $active_trigger);
			$scenario_object->set('active_trigger_custom', $active_trigger_custom);
			$scenario_object->set('pickable',              $pickable);
			$scenario_object->set('grabbable',             $grabbable);
			$scenario_object->set('breakable',             $breakable);
			$scenario_object->save();

			$this->admin_service->updateScenarioObjectFrames($scenario_object, $frames);
			$this->admin_service->updateScenarioObjectDrops($scenario_object, $drops);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para borrar un objeto de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/delete-scenario-object',
		filter: 'adminFilter'
	)]
	public function deleteScenarioObject(ORequest $req): void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$return  = $this->admin_service->deleteScenarioObject($id);
			$status  = $return['status'];
			$message = $return['message'];
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}
}