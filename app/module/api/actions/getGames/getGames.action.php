<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\GamesComponent;

#[OModuleAction(
	url: '/get-games',
	filter: 'game',
	services: ['web'],
	components: ['game/games']
)]
class getGamesAction extends OAction {
	/**
	 * Función para obtener la lista de partidas de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('game');
		$games  = $this->web_service->getGames($filter['id']);
		$games_component = new GamesComponent(['list' => $games]);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list', $games_component);
	}
}
