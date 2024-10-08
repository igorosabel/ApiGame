<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\NewGame;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Game;
use Osumi\OsumiFramework\App\Model\WorldUnlocked;
use Osumi\OsumiFramework\App\Model\Equipment;

class NewGameAction extends OAction {
  private ?WebService $ws = null;

  public string $status = 'ok';
  public string | int $id_scenario = 'null';

  public function __construct() {
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para crear una nueva partida
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_game     = $req->getParamInt('idGame');
		$name        = $req->getParamString('name');

		if (is_null($id_game) || is_null($name)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$world             = $this->ws->getOriginWorld();
				$scenario          = $world->getInitialScenario();
				$this->id_scenario = $scenario->get('id');

				$game->set('name',        $name);
				$game->set('id_scenario', $scenario->get('id'));
				$game->set('position_x',  $scenario->get('start_x'));
				$game->set('position_y',  $scenario->get('start_y'));
				$game->set('orientation', 'down');
				$game->set('money',       null);
				$game->set('health',      $this->getConfig()->getExtra('start_health'));
				$game->set('max_health',  null);
				$game->set('attack',      null);
				$game->set('defense',     null);
				$game->set('speed',       null);
				$game->save();

				$world_unlocked = new WorldUnlocked();
				$world_unlocked->set('id_game',  $game->get('id'));
				$world_unlocked->set('id_world', $world->get('id'));
				$world_unlocked->save();

				$equipment = new Equipment();
				$equipment->set('id_game', $game->get('id'));
				$equipment->set('head', null);
				$equipment->set('necklace', null);
				$equipment->set('body', null);
				$equipment->set('boots', null);
				$equipment->set('weapon', $this->getConfig()->getExtra('start_weapon'));
				$equipment->save();

				$this->ws->updateGameStats($game);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
