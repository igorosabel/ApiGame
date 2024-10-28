<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\NewGame;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Game;
use Osumi\OsumiFramework\App\Model\WorldUnlocked;
use Osumi\OsumiFramework\App\Model\Equipment;

class NewGameComponent extends OComponent {
  private ?WebService $ws = null;

  public string $status = 'ok';
  public string | int $id_scenario = 'null';

  public function __construct() {
    parent::__construct();
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para crear una nueva partida
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id_game     = $req->getParamInt('idGame');
		$name        = $req->getParamString('name');

		if (is_null($id_game) || is_null($name)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$game = Game::findOne(['id' => $id_game]);
			if (!is_null($game)) {
				$world             = $this->ws->getOriginWorld();
				$scenario          = $world->getInitialScenario();
				$this->id_scenario = $scenario->id;

				$game->name        = $name;
				$game->id_scenario = $scenario->id;
				$game->position_x  = $scenario->start_x;
				$game->position_y  = $scenario->start_y;
				$game->orientation = 'down';
				$game->money       = null;
				$game->health      = $this->getConfig()->getExtra('start_health');
				$game->max_health  = null;
				$game->attack      = null;
				$game->defense     = null;
				$game->speed       = null;
				$game->save();

				$world_unlocked = WorldUnlocked::create();
				$world_unlocked->id_game  = $game->id;
				$world_unlocked->id_world = $world->id;
				$world_unlocked->save();

				$equipment = Equipment::create();
				$equipment->id_game  = $game->id;
				$equipment->head     = null;
				$equipment->necklace = null;
				$equipment->body     = null;
				$equipment->boots    = null;
				$equipment->weapon   = $this->getConfig()->getExtra('start_weapon');
				$equipment->save();

				$this->ws->updateGameStats($game);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
