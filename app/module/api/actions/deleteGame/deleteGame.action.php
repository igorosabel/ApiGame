<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Game;

#[OModuleAction(
	url: '/delete-game',
	filter: 'game',
	services: ['web']
)]
class deleteGameAction extends OAction {
	/**
	 * Función para borrar una partida
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$id_game = $req->getParamInt('id');

		if (is_null($id_game)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$this->web_service->deleteGame($game);
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
