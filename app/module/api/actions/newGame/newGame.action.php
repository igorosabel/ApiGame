<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Game;
use OsumiFramework\App\Model\WorldUnlocked;
use OsumiFramework\App\Model\Equipment;

#[OModuleAction(
	url: '/new-game',
	filter: 'game',
	services: ['web']
)]
class newGameAction extends OAction {
	/**
	 * Función para crear una nueva partida
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
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

				$this->web_service->updateGameStats($game);
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id_scenario);
	}
}
