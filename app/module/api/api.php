<?php declare(strict_types=1);
/**
 * @type json
 * @prefix /api
*/
class api extends OModule {
	public ?webService $web_service = null;

	function __construct() {
		$this->web_service = new webService();
	}

	/**
	 * Función para iniciar sesión en el juego
	 *
	 * @url /login
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
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
			if ($user->login($email, $pass)) {
				$id = $user->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('email', $email);
				$tk->addParam('admin', $user->get('admin'));
				$tk->addParam('exp',   mktime() + (24 * 60 * 60));
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
	 * Función para registrar un nuevo usuario
	 *
	 * @url /register
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function register(ORequest $req): void {
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

			if ($user->find(['email' => $email])) {
				$status = 'in-use';
			}
			else {
				$user->set('email', $email);
				$user->set('pass',  password_hash($pass, PASSWORD_BCRYPT));
				$user->set('admin', false);
				$user->save();

				$id = $user->get('id');

				for ($i=0; $i<3; $i++) {
					$game = new Game();
					$game->set('id_user',     $user->get('id'));
					$game->set('name',        null);
					$game->set('id_scenario', null);
					$game->set('position_x',  null);
					$game->set('position_y',  null);
					$game->set('money',       $this->getConfig()->getExtra('start_money'));
					$game->set('health',      $this->getConfig()->getExtra('start_health'));
					$game->set('max_health',  $this->getConfig()->getExtra('start_health'));
					$game->set('attack',      $this->getConfig()->getExtra('start_attack'));
					$game->set('defense',     $this->getConfig()->getExtra('start_defense'));
					$game->set('speed',       $this->getConfig()->getExtra('start_speed'));
					$game->save();
				}

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('email', $email);
				$tk->addParam('admin', false);
				$tk->addParam('exp',   mktime() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
	}

	/**
	 * Función para obtener la lista de partidas de un usuario
	 *
	 * @url /get-games
	 * @filter gameFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function getGames(ORequest $req): void {
		$status = 'ok';
		$filter = $req->getFilter('gameFilter');
		$games  = $this->web_service->getGames($filter['id']);

	    $this->getTemplate()->addComponent('list', 'game/games', ['list' => $games, 'extra' => 'nourlencode']);
		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para crear una nueva partida
	 *
	 * @url /new-game
	 * @filter gameFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function newGame(ORequest $req): void {
		$status      = 'ok';
		$id_game     = $req->getParamInt('idGame');
		$name        = $req->getParamString('name');
		$id_scenario = 'null';

		if (is_null($id_game) || is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$world       = $this->web_service->getOriginWorld();
				$scenario    = $world->getInitialScenario();
				$id_scenario = $scenario->get('id');

				$game->set('name',        $name);
				$game->set('id_scenario', $scenario->get('id'));
				$game->set('position_x',  $scenario->get('start_x'));
				$game->set('position_y',  $scenario->get('start_y'));
				$game->save();

				$world_unlocked = new WorldUnlocked();
				$world_unlocked->set('id_game',  $game->get('id'));
				$world_unlocked->set('id_world', $world->get('id'));
				$world_unlocked->save();
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id_scenario);
	}

	/**
	 * Función para obtener los datos de una partida
	 *
	 * @url /get-play-data
	 * @filter gameFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function getPlayData(ORequest $req): void {
		$status            = 'ok';
		$id_game           = $req->getParamInt('id');
		$id_world          = 'null';
		$world_name        = '';
		$world_description = '';
		$id_scenario       = 'null';
		$scenario_name     = '';
		$map_url           = '';
		$blockers          = [];
		$scenario_datas    = [];
		$scenario_objects  = [];
		$characters        = [];

		if (is_null($id_game)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$scenario = $game->getScenario();
				$world    = $scenario->getWorld();

				$id_world          = $world->get('id');
				$world_name        = $world->get('name');
				$world_description = $world->get('description');
				$id_scenario       = $scenario->get('id');
				$scenario_name     = $scenario->get('name');
				$map_url           = $scenario->getMapUrl();

				$data = $scenario->getData();
				foreach ($data as $scenario_data) {
					$in_datas   = false;
					$background = $scenario_data->getBackground();
					if (!$background->get('crossable')) {
						array_push($blockers, ['x' => $scenario_data->get('x'), 'y' => $scenario_data->get('y')]);
					}
					$scenario_object = $scenario_data->getScenarioObject();
					if (!is_null($scenario_object) && $scenario_object->get('crossable')===false) {
						array_push($blockers,         ['x' => $scenario_data->get('x'), 'y' => $scenario_data->get('y')]);
						array_push($scenario_objects, $scenario_object);
						array_push($scenario_datas,   $scenario_data);
						$in_datas = true;
					}
					$character = $scenario_data->getCharacter();
					if (!is_null($character)) {
						array_push($blockers,   ['x' => $scenario_data->get('x'), 'y' => $scenario_data->get('y')]);
						array_push($characters, $character);
						if (!$in_datas) {
							array_push($scenario_datas, $scenario_data);
						}
					}
				}

				$this->getTemplate()->addComponent('game', 'game/game', ['game' => $game, 'extra' => 'nourlencode']);
			}
			else {
				$status = 'error';
				$this->getTemplate()->add('game', 'null');
			}
		}

		$this->getTemplate()->add('status',            $status);
		$this->getTemplate()->add('id_world',          $id_world);
		$this->getTemplate()->add('world_name',        $world_name);
		$this->getTemplate()->add('world_description', $world_description);
		$this->getTemplate()->add('id_scenario',       $id_scenario);
		$this->getTemplate()->add('scenario_name',     $scenario_name);
		$this->getTemplate()->add('map_url',           $map_url);
		$this->getTemplate()->addComponent('blockers',         'game/blockers',          ['list' => $blockers,         'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('scenario_datas',   'admin/scenario_datas',   ['list' => $scenario_datas,   'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('scenario_objects', 'admin/scenario_objects', ['list' => $scenario_objects, 'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('characters',       'admin/characters',       ['list' => $characters,       'extra' => 'nourlencode']);
	}
}