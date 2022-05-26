<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Game;

#[OModuleAction(
	url: '/update-position',
	filter: 'game'
)]
class updatePositionAction extends OAction {
	/**
	 * Función para guardar la última posición de un jugador
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status      = 'ok';
		$id_game     = $req->getParamInt('idGame');
		$x           = $req->getParamInt('x');
		$y           = $req->getParamInt('y');
		$orientation = $req->getParamString('orientation');

		if (is_null($id_game) || is_null($x) || is_null($y) || is_null($orientation)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
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
