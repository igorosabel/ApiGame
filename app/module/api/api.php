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
				$in_scenario_objects = [];
				$in_characters = [];
				foreach ($data as $scenario_data) {
					$in_datas   = false;
					$background = $scenario_data->getBackground();
					if (!$background->get('crossable')) {
						array_push($blockers, ['x' => $scenario_data->get('x'), 'y' => $scenario_data->get('y')]);
					}
					$scenario_object = $scenario_data->getScenarioObject();
					if (!is_null($scenario_object) && $scenario_object->get('crossable')===false) {
						array_push($blockers,         ['x' => $scenario_data->get('x'), 'y' => $scenario_data->get('y')]);
						if (!in_array($scenario_object->get('id'), $in_scenario_objects)) {
							array_push($scenario_objects, $scenario_object);
							array_push($in_scenario_objects, $scenario_object->get('id'));
						}
						array_push($scenario_datas,   $scenario_data);
						$in_datas = true;
					}
					$character = $scenario_data->getCharacter();
					if (!is_null($character)) {
						if (!in_array($character->get('id'), $in_characters)) {
							array_push($characters, $character);
							array_push($in_characters, $character->get('id'));
						}
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

	/**
	 * Función para obtener los mundos que un jugador a desbloqueado
	 *
	 * @url /get-unlocked-worlds
	 * @filter gameFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function getUnlockedWorlds(ORequest $req): void {
		$status  = 'ok';
		$id_game = $req->getParamInt('id');
		$list    = [];

		if (is_null($id_game)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$list = $this->web_service->getUnlockedWorlds($id_game);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'admin/worlds', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para obtener las conexiones de un escenario
	 *
	 * @url /get-scenario-connections
	 * @filter gameFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function getScenarioConnections(ORequest $req): void {
		$status      = 'ok';
		$id_scenario = $req->getParamInt('id');
		$list        = [];

		if (is_null($id_scenario)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id_scenario])){
				$list = $scenario->getConnections();
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'admin/connections', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para viajar a otro mundo
	 *
	 * @url /travel
	 * @filter gameFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function travel(ORequest $req): void {
		$status     = 'ok';
		$id_game   = $req->getParamInt('idGame');
		$id_world   = $req->getParamInt('idWorld');
		$word_one   = $req->getParamString('wordOne');
		$word_two   = $req->getParamString('wordTwo');
		$word_three = $req->getParamString('wordThree');

		if (is_null($id_game) || is_null($word_one) || is_null($word_two) || is_null($word_three)) {
			$status = 'error';
		}

		if ($status=='ok') {
			// Si viene id es que es un mundo ya conocido
			if (!is_null($id)) {
				$world = new World();
				if (!$world->find(['id' => $id])) {
					$world = null;
				}
			}
			// Si no viene id es que está probando a ir a un mundo nuevo
			else {
				$world = $this->web_service->getWorldByWords( strtolower($word_one), strtolower($word_two), strtolower($word_three));
			}

			if (!is_null($world)) {
				$id_world = $world->get('id');

				$world_unlocked = new WorldUnlocked();
				$world_unlocked->set('id_game', $id_game);
				$world_unlocked->set('id_world', $id_world);
				$world_unlocked->save();

				// TODO actualizar Game con la posición inicial del mundo al que va y orientation down
			}
			else {
				$status = 'error';
				$id_world = 'null';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id_world);
	}

	/**
	 * Función para cambiar de escenario
	 *
	 * @url /change-scenario
	 * @filter gameFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function changeScenario(ORequest $req): void {
		$status  = 'ok';
		$to      = $req->getParamInt('to');
		$x       = $req->getParamInt('x');
		$y       = $req->getParamInt('y');
		$id_game = $req->getParamInt('idGame');

		if (is_null($to) || is_null($x) || is_null($y) || is_null($id_game)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$changed_x = false;
				$changed_y = false;
				$orientation = 'down';
				if ($x==$this->getConfig()->getExtra('width')) {
					$x = 0;
					$orientation = 'right';
					$changed_x = true;
				}
				if ($y==$this->getConfig()->getExtra('height')) {
					$y = 0;
					$orientation = 'down';
					$changed_y = true;
				}
				if (!$changed_x && $x==0) {
					$x = ($this->getConfig()->getExtra('width') - 1);
					$orientation = 'right';
				}
				if (!$changed_y && $y==0) {
					$y = ($this->getConfig()->getExtra('height') - 1);
					$orientation = 'up';
				}

				$game->set('id_scenario', $to);
				$game->set('position_x',  $x);
				$game->set('position_y',  $y);
				$game->set('orientation', $orientation);
				$game->save();
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}