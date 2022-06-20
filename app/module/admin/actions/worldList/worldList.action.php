<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\WorldsComponent;

#[OModuleAction(
	url: '/world-list',
	filter: 'admin',
	services: ['admin'],
	components: ['model/worlds']
)]
class worldListAction extends OAction {
	/**
	 * Función para obtener la lista de mundos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$worlds_component = new WorldsComponent(['list' => $this->admin_service->getWorlds()]);
		$this->getTemplate()->add('list', $worlds_component);
	}
}
