<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\ChangeScenario;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Game;

class ChangeScenarioComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para cambiar de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$to      = $req->getParamInt('to');
		$x       = $req->getParamInt('x');
		$y       = $req->getParamInt('y');
		$id_game = $req->getParamInt('idGame');

		if (is_null($to) || is_null($x) || is_null($y) || is_null($id_game)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$game = Game::findOne(['id' => $id_game]);

			if (!is_null($game)) {
				$changed_x = false;
				$changed_y = false;
				$orientation = 'down';
				if ($x === $this->getConfig()->getExtra('width')) {
					$x = 0;
					$orientation = 'right';
					$changed_x = true;
				}
				if ($y === $this->getConfig()->getExtra('height')) {
					$y = 0;
					$orientation = 'down';
					$changed_y = true;
				}
				if (!$changed_x && $x === 0) {
					$x = ($this->getConfig()->getExtra('width') - 1);
					$orientation = 'right';
				}
				if (!$changed_y && $y === 0) {
					$y = ($this->getConfig()->getExtra('height') - 1);
					$orientation = 'up';
				}

				$game->id_scenario = $to;
				$game->position_x  = $x;
				$game->position_y  = $y;
				$game->orientation = $orientation;
				$game->save();
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
