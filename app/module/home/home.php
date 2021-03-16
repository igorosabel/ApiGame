<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Core\OModule;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Routing\ORoute;
use OsumiFramework\App\Model\Game;
use OsumiFramework\App\Service\webService;

#[ORoute(
	type: 'html'
)]
class home extends OModule {
	public ?webService $web_service = null;

	function __construct() {
		$this->web_service = new webService();
	}

	/**
	 * Pantalla de inicio
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/')]
	public function index(ORequest $req): void {
		$this->getTemplate()->addCss('home');
	    $this->getTemplate()->addJs('home');
	}

	/**
	 * Nueva acción playerSelect
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/player-select',
		filter: 'playerFilter'
	)]
	public function playerSelect(ORequest $req): void {
	    $games = $this->web_service->getGames($this->getSession()->getParam('id'));
	    $this->getTemplate()->addComponent('games', 'public/games', ['games' => $games]);

	    $this->getTemplate()->addCss('player-select');
	}

	/**
	 * Pantalla de juego
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/game/:id',
		type: 'html'
	)]
	public function game(ORequest $req): void {
		$game = new Game();
	    $game->find(['id'=>$req->getParamInt('id')]);
	    $scn = $game->getScenario();
	    $assets = $this->web_service->getAssetsData($scn->get('data'));

	    $this->getTemplate()->addComponent('assets', 'public/canvas_assets', ['assets' => $assets['assets']]);

	    $res = [
	      'bck' => $assets['bck'],
	      'spr' => $assets['spr'],
	      'player' => [
	        'player_up'    => ['url' => 'link-up', 'crossable' => false],
	        'player_up_walking_1'    => ['url' => 'up-walking-1',    'crossable' => false],
	        'player_up_walking_2'    => ['url' => 'up-walking-2',    'crossable' => false],
	        'player_up_walking_3'    => ['url' => 'up-walking-3',    'crossable' => false],
	        'player_up_walking_4'    => ['url' => 'up-walking-4',    'crossable' => false],
	        'player_up_walking_5'    => ['url' => 'up-walking-5',    'crossable' => false],
	        'player_up_walking_6'    => ['url' => 'up-walking-6',    'crossable' => false],
	        'player_up_walking_7'    => ['url' => 'up-walking-7',    'crossable' => false],
	        'player_right' => ['url'=>'link-right', 'crossable' => false],
	        'player_right_walking_1' => ['url' => 'right-walking-1', 'crossable' => false],
	        'player_right_walking_2' => ['url' => 'right-walking-2', 'crossable' => false],
	        'player_right_walking_3' => ['url' => 'right-walking-3', 'crossable' => false],
	        'player_right_walking_4' => ['url' => 'right-walking-4', 'crossable' => false],
	        'player_right_walking_5' => ['url' => 'right-walking-5', 'crossable' => false],
	        'player_right_walking_6' => ['url' => 'right-walking-6', 'crossable' => false],
	        'player_right_walking_7' => ['url' => 'right-walking-7', 'crossable' => false],
	        'player_down'  => ['url'=>'link-down', 'crossable' => false],
	        'player_down_walking_1'  => ['url' => 'down-walking-1',  'crossable' => false],
	        'player_down_walking_2'  => ['url' => 'down-walking-2',  'crossable' => false],
	        'player_down_walking_3'  => ['url' => 'down-walking-3',  'crossable' => false],
	        'player_down_walking_4'  => ['url' => 'down-walking-4',  'crossable' => false],
	        'player_down_walking_5'  => ['url' => 'down-walking-5',  'crossable' => false],
	        'player_down_walking_6'  => ['url' => 'down-walking-6',  'crossable' => false],
	        'player_down_walking_7'  => ['url' => 'down-walking-7',  'crossable' => false],
	        'player_left'  => ['url'=>'link-left', 'crossable' => false],
	        'player_left_walking_1'  => ['url' => 'left-walking-1',  'crossable' => false],
	        'player_left_walking_2'  => ['url' => 'left-walking-2',  'crossable' => false],
	        'player_left_walking_3'  => ['url' => 'left-walking-3',  'crossable' => false],
	        'player_left_walking_4'  => ['url' => 'left-walking-4',  'crossable' => false],
	        'player_left_walking_5'  => ['url' => 'left-walking-5',  'crossable' => false],
	        'player_left_walking_6'  => ['url' => 'left-walking-6',  'crossable' => false],
	        'player_left_walking_7'  => ['url' => 'left-walking-7',  'crossable' => false]
		],
		'hud' => [
			'hud_heart_full'  => ['url' => 'heart_full',  'crossable' => false],
			'hud_heart_half'  => ['url' => 'heart_half',  'crossable' => false],
			'hud_heart_empty' => ['url' => 'heart_empty', 'crossable' => false],
			'hud_money'       => ['url' => 'money',       'crossable' => false]
		]
	  ];

	    $this->getTemplate()->add('res', json_encode($res));
	    $this->getTemplate()->add('position_x',  $game->get('position_x'));
	    $this->getTemplate()->add('position_y',  $game->get('position_y'));

	    $this->getTemplate()->addCss('game');
	}
}