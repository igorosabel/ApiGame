<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Game;

#[OModuleAction(
	url: '/change-scenario',
	filters: ['game']
)]
class changeScenarioAction extends OAction {
	/**
	 * Función para cambiar de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
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
