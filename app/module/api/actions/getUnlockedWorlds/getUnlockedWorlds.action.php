<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\WorldsComponent;

#[OModuleAction(
	url: '/get-unlocked-worlds',
	filter: 'game',
	services: 'web',
	components: 'model/worlds'
)]
class getUnlockedWorldsAction extends OAction {
	/**
	 * Función para obtener los mundos que un jugador a desbloqueado
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$id_game = $req->getParamInt('id');
		$worlds_component = new WorldsComponent(['list' => [], 'extra' => 'nourlencode']);

		if (is_null($id_game)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$list = $this->web_service->getUnlockedWorlds($id_game);
			$worlds_component = new WorldsComponent(['list' => $list, 'extra' => 'nourlencode']);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $worlds_component);
	}
}
