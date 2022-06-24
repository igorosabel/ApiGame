<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\BackgroundsComponent;

#[OModuleAction(
	url: '/background-list',
	filters: ['admin'],
	services: ['admin'],
	components: ['model/backgrounds']
)]
class backgroundListAction extends OAction {
	/**
	 * Función para obtener la lista de fondos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$backgrounds_component = new BackgroundsComponent(['list' => $this->admin_service->getBackgrounds()]);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $backgrounds_component);
	}
}
