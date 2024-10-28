<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\HitEnemy;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Game;
use Osumi\OsumiFramework\App\Model\ScenarioData;

class HitEnemyComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para golpear a un enemigo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id_game          = $req->getParamInt('idGame');
		$id_scenario_data = $req->getParamInt('idScenarioData');

		if (is_null($id_game) || is_null($id_scenario_data)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$game = Game::findOne(['id' => $id_game]);
			if (is_null($game)) {
				$status = 'error';
			}
			$scenario_data = ScenarioData::findOne(['id' => $id_scenario_data]);
			if (is_null($scenario_data)) {
				$this->status = 'error';
			}

			if ($this->status === 'ok') {
				$enemy = $scenario_data->getCharacter();
				$damage = $game->attack - $enemy->defense;
				$hp = $scenario_data->character_health - $damage;
				if ($hp < 0) {
					$hp = 0;
				}
				$scenario_data->character_health = $hp;
				$scenario_data->save();
			}
		}
	}
}
