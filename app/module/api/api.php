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
		$this->getTemplate()->add('id', $id);
		$this->getTemplate()->add('name', $name);
		$this->getTemplate()->add('token', $token);
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

			if ($user->find(['email'=>$email])) {
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
					$game->set('id_user', $user->get('id'));
					$game->set('name', null);
					$game->set('id_scenario', null);
					$game->set('position_x', null);
					$game->set('position_y', null);
					$game->set('money', $this->getConfig()->getExtra('start_money'));
					$game->set('health', $this->getConfig()->getExtra('start_health'));
					$game->set('max_health', $this->getConfig()->getExtra('start_health'));
					$game->set('attack', $this->getConfig()->getExtra('start_attack'));
					$game->set('defense', $this->getConfig()->getExtra('start_defense'));
					$game->set('speed', $this->getConfig()->getExtra('start_speed'));
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
		$this->getTemplate()->add('id', $id);
		$this->getTemplate()->add('name', $name);
		$this->getTemplate()->add('token', $token);
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
		$games = $this->web_service->getGames($filter['id']);

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
		$status  = 'ok';
		$id_game = $req->getParamInt('idGame');
		$name    = $req->getParamString('name');
		$id_scenario = 'null';

		if (is_null($id_game) || is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$world = $this->web_service->getOriginWorld();
				$scenario = $world->getInitialScenario();
				$id_scenario = $scenario->get('id');

				$game->set('name', $name);
				$game->set('id_scenario', $scenario->get('id'));
				$game->set('position_x', $scenario->get('start_x'));
				$game->set('position_y', $scenario->get('start_y'));
				$game->save();

				$world_unlocked = new WorldUnlocked();
				$world_unlocked->set('id_game', $game->get('id'));
				$world_unlocked->set('id_world', $world->get('id'));
				$world_unlocked->save();
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id', $id_scenario);
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
		$status  = 'ok';
		$id_game = $req->getParamInt('id');
		$id_world = 'null';
		$world_name = '';
		$world_description = '';
		$id_scenario = 'null';
		$scenario_name = '';
		$map_url = '';
		$scenario_objects = [];
		$characters = [];

		if (is_null($id_game)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$scenario = $game->getScenario();
				$world = $scenario->getWorld();

				$id_world = $world->get('id');
				$world_name = $world->get('name');
				$world_description = $world->get('description');
				$id_scenario = $scenario->get('id');
				$scenario_name = $scenario->get('name');
				$map_url = $scenario->getMapUrl();

				$data = $scenario->getData();
				foreach ($data as $scenario_data) {
					$scenario_object = $scenario_data->getScenarioObject();
					if (!is_null($scenario_object) && $scenario_object->get('crossable')===false) {
						array_push($scenario_objects, $scenario_object);
					}
					$character = $scenario_data->getCharacter();
					if (!is_null($character)) {
						array_push($characters, $character);
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
		$this->getTemplate()->addComponent('scenario_objects', 'admin/scenario_objects', ['list' => $scenario_objects, 'extra' => 'nourlencode']);
		$this->getTemplate()->addComponent('characters',       'admin/characters',       ['list' => $characters,       'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un escenario editado
	 *
	 * @url /save-scenario
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveScenario(ORequest $req): void {
		$status   = 'ok';
		$id       = $req->getParamInt('id');
		$name     = $req->getParamString('name');
		$scenario = $req->getParamString('scenario');
		$start_x  = $req->getParamInt('start_x');
		$start_y  = $req->getParamInt('start_y');
		$initial  = $req->getParamBool('initial');

		if (is_null($id) || is_null($name) || is_null($scenario) || is_null($start_x) || is_null($start_y) || is_null($initial)) {
		  $status = 'error';
		}

		if ($status=='ok') {
		  $scn = new Scenario();
		  if ($scn->find(['id'=>$id])) {
			$scn->set('name',    urldecode($name));
			$scn->set('data',    $scenario);
			$scn->set('start_x', $start_x);
			$scn->set('start_y', $start_y);
			$scn->set('initial', $initial);
			$scn->save();
		  }
		  else {
			$status = 'error';
		  }
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para guardar una categoría de fondos
	 *
	 * @url /save-background-category
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveBackgroundCategory(ORequest $req): void {
	    $status = 'ok';
	    $name   = $req->getParamString('name');
	    $id     = $req->getParamInt('id');
	    $is_new = 'true';

	    if (is_null($name)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $name = urldecode($name);
	      $bckc = new BackgroundCategory();
	      if ($id!==0) {
	        $bckc->find(['id'=>$id]);
	        $is_new = 'false';
	      }
	      $bckc->set('name', $name);
	      $bckc->set('slug', OTools::slugify($name));
	      $bckc->save();

	      $id = $bckc->get('id');
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	    $this->getTemplate()->add('name',   $name);
	    $this->getTemplate()->add('is_new', $is_new);
	}

	/**
	 * Función para borrar una categoría de fondos
	 *
	 * @url /delete-background-category
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteBackgroundCategory(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    if (is_null($id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $bckc = new BackgroundCategory();
	      if ($bckc->find(['id'=>$id])) {
	        $bckc->deleteFull();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	}

	/**
	 * Función para guardar un fondo
	 *
	 * @url /save-background
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveBackground(ORequest $req): void {
		$status      = 'ok';
	    $id          = $req->getParamInt('id');
	    $id_category = $req->getParamInt('id_category');
	    $name        = $req->getParamString('name');
	    $file_name   = $req->getParamString('file_name');
	    $file        = $req->getParamString('file');
	    $crossable   = $req->getParamBool('crossable');
	    $is_new      = 'true';

	    if (is_null($id) || is_null($id_category) || is_null($name) || is_null($crossable)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $name  = urldecode($name);

	      $bck = new Background();
	      if ($id!==0) {
	        $bck->find(['id'=>$id]);
	        $is_new = 'false';
	      }
	      $bck->set('id_category', $id_category);
	      $bck->set('name',        $name);
	      if ($file_name!='') {
	        $bck->set('file', str_ireplace('.png', '', $file_name));
	      }
	      $bck->set('crossable', $crossable);
	      $bck->save();

	      if ($file_name!='') {
	        $bckc = new BackgroundCategory();
	        $bckc->find(['id'=>$id_category]);
	        $category = $bckc->get('slug');

	        $ruta = $c->getDir('assets').'background/'.$bckc->get('slug').'/'.$file_name;
	        $this->web_service->saveImage($ruta, $file);
	      }

	      $id = $bck->get('id');
	      $saved_file = $spr->get('file');
	    }

	    $this->getTemplate()->add('status',      $status);
	    $this->getTemplate()->add('id',          $id);
	    $this->getTemplate()->add('id_category', $id_category);
	    $this->getTemplate()->add('name',        $name);
	    $this->getTemplate()->add('saved_file',  $saved_file);
	    $this->getTemplate()->add('category',    $category);
	    $this->getTemplate()->add('crossable',   $crossable);
	    $this->getTemplate()->add('is_new',      $is_new);
	}

	/**
	 * Función para borrar un fondo
	 *
	 * @url /delete-background
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteBackground(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    if (is_null($id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $bck = new Background();
	      if ($bck->find(['id'=>$id])) {
	        // Primero borro el archivo
	        $bckc = new BackgroundCategory();
	        $bckc->find(['id'=>$bck->get('id_category')]);

	        $ruta = $this->getConfig()->getDir('assets').'background/'.$bckc->get('slug').'/'.$bck->get('file').'.png';
	        if (file_exists($ruta)) {
	          unlink($ruta);
	        }

	        // Luego el registro
	        $bck->delete();
	      }
	      else{
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	}

	/**
	 * Función para guardar una categoría de sprites
	 *
	 * @url /save-sprite-category
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveSpriteCategory(ORequest $req): void {
	    $status = 'ok';
	    $name   = $req->getParamString('name');
	    $id     = $req->getParamInt('id');
	    $is_new = 'true';

	    if (is_null($name)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $name = urldecode($name);
	      $sprc = new SpriteCategory();
	      if ($id!==0) {
	        $sprc->find(['id'=>$id]);
	        $is_new = 'false';
	      }
	      $sprc->set('name', $name);
	      $sprc->set('slug', OTools::slugify($name));
	      $sprc->save();

	      $id = $sprc->get('id');
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	    $this->getTemplate()->add('name',   $name);
	    $this->getTemplate()->add('is_new', $is_new);
	}

	/**
	 * Función para borrar una categoría de sprites
	 *
	 * @url /delete-sprite-category
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteSpriteCategory(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    if (is_null($id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $sprc = new SpriteCategory();
	      if ($sprc->find(['id'=>$id])) {
	        $sprc->deleteFull();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	}

	/**
	 * Función para obtener los datos de un sprite
	 *
	 * @url /get-sprite
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function getSprite(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    $id_category = 0;
	    $name        = '';
	    $file        = '';
	    $url         = '';
	    $crossable   = 'false';
	    $width       = 0;
	    $height      = 0;
	    $frames      = [];

	    if (is_null($id)) {
	      $status = 'error';
	      $id = 0;
	    }

	    if ($status=='ok') {
	      $spr = new Sprite();
	      if ($spr->find(['id'=>$id])) {
	        $id_category = $spr->get('id_category');
	        $name        = $spr->get('name');
	        $file        = $spr->get('file');
	        $url         = $spr->getUrl();
	        $crossable   = $spr->get('crossable') ? 'true' : 'false';
	        $width       = $spr->get('width');
	        $height      = $spr->get('height');
	        $frames      = $spr->getFrames();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status',      $status);
	    $this->getTemplate()->add('id',          $id);
	    $this->getTemplate()->add('id_category', $id_category);
	    $this->getTemplate()->add('name',        $name);
	    $this->getTemplate()->add('file',        $file);
	    $this->getTemplate()->add('url',         $url);
	    $this->getTemplate()->add('crossable',   $crossable);
	    $this->getTemplate()->add('width',       $width);
	    $this->getTemplate()->add('height',      $height);
	    $this->getTemplate()->addComponent('frames', 'api/getSpriteFrames', ['frames' => $frames, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un sprite
	 *
	 * @url /save-sprite
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveSprite(ORequest $req): void {
	    $status      = 'ok';
	    $id          = $req->getParamInt('id');
	    $id_category = $req->getParamInt('id_category');
	    $name        = $req->getParamString('name');
	    $file        = $req->getParamString('file');
	    $data        = $req->getParamString('data');
	    $width       = $req->getParamInt('width');
	    $height      = $req->getParamInt('height');
	    $crossable   = $req->getParamBool('crossable');
	    $frames      = $req->getParamString('frames');
	    $is_new      = 'true';
	    $url         = '';
	    $category    = '';

	    if (is_null($id) || is_null($id_category) || is_null($name) || is_null($width) || is_null($height) || is_null($crossable)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $name  = urldecode($name);
	      $frames = json_decode($frames,true);

	      $spr = new Sprite();
	      if ($id!==0) {
	        $spr->find(['id'=>$id]);
	        $is_new = 'false';
	      }
	      $spr->set('id_category', $id_category);
	      $spr->set('name',        $name);
	      if ($file!='') {
	        $spr->set('file', str_ireplace('.png', '', $file));
	      }
	      $spr->set('width',     $width);
	      $spr->set('height',    $height);
	      $spr->set('crossable', $crossable);
	      $spr->save();

	      if ($data!='') {
	        $ruta = $this->getConfig()->getDir('assets').'sprite/'.$spr->getCategory()->get('slug').'/'.$file;
	        $this->web_service->saveImage($ruta, $data);
	      }

	      if (count($frames)>0) {
	        $order = 0;
	        foreach ($frames as $frame) {
	          $order++;

	          $fr = new SpriteFrame();
	          if ($frame['id']!=0) {
	            $fr->find(['id'=>$frame['id']]);
	          }
	          $fr->set('id_sprite', $spr->get('id'));
	          $fr->set('order', $order);

	          if (array_key_exists('data', $frame)) {
	            if ($frame['file']!=$fr->get('file') && $fr->get('file')!='') {
	              $ruta = $this->getConfig()->getDir('assets').'sprite/'.$spr->getCategory()->get('slug').'/'.$fr->get('file');
	              unlink($ruta);
	            }
	            $ruta = $this->getConfig()->getDir('assets').'sprite/'.$spr->getCategory()->get('slug').'/'.$frame['file'];
	            $this->web_service->saveImage($ruta, $frame['data']);
	          }
	          if (array_key_exists('delete', $frame)) {
	            $fr->deleteFull();
	          }
	          else {
	            if (array_key_exists('file', $frame)) {
	              $fr->set('file', str_ireplace('.png', '', $frame['file']));
	            }
	            $fr->save();
	          }
	        }
	        $spr->set('frames',$order);
	        $spr->save();
	      }

	      $id  = $spr->get('id');
	      $url = $spr->getUrl();
	    }

	    $this->getTemplate()->add('status',      $status);
	    $this->getTemplate()->add('id',          $id);
	    $this->getTemplate()->add('id_category', $id_category);
	    $this->getTemplate()->add('name',        $name);
	    $this->getTemplate()->add('file',        $file);
	    $this->getTemplate()->add('url',         $url);
	    $this->getTemplate()->add('width',       $width);
	    $this->getTemplate()->add('height',      $height);
	    $this->getTemplate()->add('crossable',   $crossable);
	    $this->getTemplate()->add('is_new',      $is_new);
	}

	/**
	 * Función para borrar un sprite
	 *
	 * @url /delete-sprite
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteSprite(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    if (is_null($id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $spr = new Sprite();
	      if ($spr->find(['id'=>$id])) {
	        // Primero borro el archivo
	        $sprc = new SpriteCategory();
	        $sprc->find(['id'=>$spr->get('id_category')]);

	        $ruta = $this->getConfig()->getDir('assets').'sprite/'.$sprc->get('slug').'/'.$spr->get('file').'.png';
	        if (file_exists($ruta)) {
	          unlink($ruta);
	        }

	        // Luego el registro
	        $spr->delete();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	}

	/**
	 * Función para obtener los datos de un elemento interactivo
	 *
	 * @url /get-interactive
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function getInteractive(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    $name               = '';
	    $type               = 0;
	    $activable          = 'false';
	    $pickable           = 'false';
	    $grabbable          = 'false';
	    $breakable          = 'false';
	    $crossable          = 'false';
	    $crossable_active   = 'false';
	    $sprite_start_id    = 0;
	    $sprite_start_name  = '';
	    $sprite_start_url   = '';
	    $sprite_active_id   = 0;
	    $sprite_active_name = '';
	    $sprite_active_url  = '';
	    $drops              = 0;
	    $quantity           = 0;
	    $active_time        = 0;

	    if (is_null($id)) {
	      $status = 'error';
	      $id = 0;
	    }

	    if ($status=='ok') {
	      $int = new Interactive();
	      if ($int->find(['id'=>$id])) {
	        $spr_start  = $int->getSpriteStart();
	        $spr_active = $int->getSpriteActive();

	        $name               = $int->get('name');
	        $type               = $int->get('type');
	        $activable          = $int->get('activable') ? 'true' : 'false';
	        $pickable           = $int->get('pickable') ? 'true' : 'false';
	        $grabbable          = $int->get('grabbable') ? 'true' : 'false';
	        $breakable          = $int->get('breakable') ? 'true' : 'false';
	        $crossable          = $int->get('crossable') ? 'true' : 'false';
	        $crossable_active   = $int->get('crossable_active') ? 'true' : 'false';
	        $sprite_start_id    = $spr_start->get('id');
	        $sprite_start_name  = $spr_start->get('name');
	        $sprite_start_url   = $spr_start->getUrl();
	        $sprite_active_id   = $spr_active->get('id');
	        $sprite_active_name = $spr_active->get('name');
	        $sprite_active_url  = $spr_active->getUrl();
	        $drops              = $int->get('drops');
	        $quantity           = $int->get('quantity');
	        $active_time        = $int->get('active_time');
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status',             $status);
	    $this->getTemplate()->add('id',                 $id);
	    $this->getTemplate()->add('name',               $name);
	    $this->getTemplate()->add('type',               $type);
	    $this->getTemplate()->add('activable',          $activable);
	    $this->getTemplate()->add('pickable',           $pickable);
	    $this->getTemplate()->add('grabbable',          $grabbable);
	    $this->getTemplate()->add('breakable',          $breakable);
	    $this->getTemplate()->add('crossable',          $crossable);
	    $this->getTemplate()->add('crossable_active',   $crossable_active);
	    $this->getTemplate()->add('sprite_start_id',    $sprite_start_id);
	    $this->getTemplate()->add('sprite_start_name',  $sprite_start_name);
	    $this->getTemplate()->add('sprite_start_url',   $sprite_start_url);
	    $this->getTemplate()->add('sprite_active_id',   $sprite_active_id);
	    $this->getTemplate()->add('sprite_active_name', $sprite_active_name);
	    $this->getTemplate()->add('sprite_active_url',  $sprite_active_url);
	    $this->getTemplate()->add('drops',              $drops);
	    $this->getTemplate()->add('quantity',           $quantity);
	    $this->getTemplate()->add('active_time',        $active_time);
	}

	/**
	 * Función para guardar un elemento interactivo
	 *
	 * @url /save-interactive
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveInteractive(ORequest $req): void {
	    $status           = 'ok';
	    $id               = $req->getParamInt('id');
	    $name             = $req->getParamString('name');
	    $type             = $req->getParamInt('type');
	    $activable        = $req->getParamBool('activable');
	    $pickable         = $req->getParamBool('pickable');
	    $grabbable        = $req->getParamBool('grabbable');
	    $breakable        = $req->getParamBool('breakable');
	    $crossable        = $req->getParamBool('crossable');
	    $crossable_active = $req->getParamBool('crossable_active');
	    $drops            = $req->getParamInt('drops');
	    $quantity         = $req->getParamInt('quantity');
	    $active_time      = $req->getParamInt('active_time');
	    $sprite_start_id  = $req->getParamInt('sprite_start_id');
	    $sprite_active_id = $req->getParamInt('sprite_active_id');

	    $url    = '';
	    $is_new = 'true';

	    if (is_null($id) || is_null($name) || is_null($type) || is_null($drops) || is_null($quantity) || is_null($active_time) || is_null($sprite_start_id) || is_null($sprite_active_id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $name = urldecode($name);

	      $int = new Interactive();
	      if ($id!==0) {
	        $int->find(['id'=>$id]);
	        $is_new = 'false';
	      }
	      $int->set('name',             $name);
	      $int->set('type',             $type);
	      $int->set('activable',        $activable);
	      $int->set('pickable',         $pickable);
	      $int->set('grabbable',        $grabbable);
	      $int->set('breakable',        $breakable);
	      $int->set('crossable',        $crossable);
	      $int->set('crossable_active', $crossable_active);
	      $int->set('drops',            $drops);
	      $int->set('quantity',         $quantity);
	      $int->set('active_time',      $active_time);
	      $int->set('sprite_start',     $sprite_start_id);
	      $int->set('sprite_active',    $sprite_active_id);

	      $int->save();

	      $id  = $int->get('id');
	      $url = $int->getSpriteStart()->getUrl();
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('is_new', $is_new);
	    $this->getTemplate()->add('id',     $id);
	    $this->getTemplate()->add('name',   $name);
	    $this->getTemplate()->add('url',    $url);
	}

	/**
	 * Función para borrar un elemento interactivo
	 *
	 * @url /delete-interactive
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteInteractive(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    if (is_null($id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $int = new Interactive();
	      if ($int->find(['id'=>$id])){
	        $int->delete();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	}

	/**
	 * Función para guardar un usuario
	 *
	 * @url /save-user
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveUser(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');
	    $email  = $req->getParamString('email');
	    $pass   = $req->getParamString('pass');

	    if (is_null($id) || is_null($email) || is_null($pass)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $email = urldecode($email);
	      $pass  = urldecode($pass);

	      $u = new User();
	      if ($u->find(['id'=>$id])) {
	        $u->set('email', $email);
	        if ($pass!='') {
	          $u->set('pass',  sha1('gam_'.$pass.'_gam'));
	        }
	        $u->save();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	    $this->getTemplate()->add('email',  $email);
	}

	/**
	 * Función para borrar un usuario
	 *
	 * @url /delete-user
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteUser(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    if (is_null($id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $u = new User();
	      if ($u->find(['id'=>$id])) {
	        $u->deleteFull();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	}

	/**
	 * Función para guardar una partida
	 *
	 * @url /save-game
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function saveGame(ORequest $req): void {
	    $status      = 'ok';
	    $id          = $req->getParamInt('id');
	    $name        = $req->getParamString('name');
	    $id_scenario = $req->getParamInt('id_scenario');
	    $x           = $req->getParamInt('x');
	    $y           = $req->getParamInt('y');
	    $scenario    = '';

	    if (is_null($id) || is_null($name) || is_null($id_scenario) || is_null($x) || is_null($y)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $name = urldecode($name);
	      $game = new Game();
	      if ($game->find(['id'=>$id])) {
	        $game->set('name',        $name);
	        $game->set('id_scenario', $id_scenario);
	        $game->set('position_x',  $x);
	        $game->set('position_y',  $y);
	        $game->save();

	        $scenario = $game->getScenario()->get('name');
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status',      $status);
	    $this->getTemplate()->add('id',          $id);
	    $this->getTemplate()->add('name',        $name);
	    $this->getTemplate()->add('id_scenario', $id_scenario);
	    $this->getTemplate()->add('scenario',    $scenario);
	    $this->getTemplate()->add('x',           $x);
	    $this->getTemplate()->add('y',           $y);
	}

	/**
	 * Función para borrar una partida
	 *
	 * @url /delete-game
	 * @filter adminFilter
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function deleteGame(ORequest $req): void {
	    $status = 'ok';
	    $id     = $req->getParamInt('id');

	    if (is_null($id)) {
	      $status = 'error';
	    }

	    if ($status=='ok') {
	      $game = new Game();
	      if ($game->find(['id'=>$id])) {
	        $game->set('name',        null);
	        $game->set('id_scenario', null);
	        $game->set('position_x',  null);
	        $game->set('position_y',  null);
	        $game->save();
	      }
	      else {
	        $status = 'error';
	      }
	    }

	    $this->getTemplate()->add('status', $status);
	    $this->getTemplate()->add('id',     $id);
	}
}