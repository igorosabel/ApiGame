<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\HitEnemy;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Game;
use Osumi\OsumiFramework\App\Model\ScenarioData;

class HitEnemyAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para golpear a un enemigo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_game          = $req->getParamInt('idGame');
		$id_scenario_data = $req->getParamInt('idScenarioData');

		if (is_null($id_game) || is_null($id_scenario_data)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$game = new Game();
			if (!$game->find(['id' => $id_game])) {
				$status = 'error';
			}
			$scenario_data = new ScenarioData();
			if (!$scenario_data->find(['id' => $id_scenario_data])) {
				$this->status = 'error';
			}

			if ($this->status=='ok') {
				$enemy = $scenario_data->getCharacter();
				$damage = $game->get('attack') - $enemy->get('defense');
				$hp = $scenario_data->get('character_health') - $damage;
				if ($hp < 0) {
					$hp = 0;
				}
				$scenario_data->set('character_health', $hp);
				$scenario_data->save();
			}
		}
	}
}
