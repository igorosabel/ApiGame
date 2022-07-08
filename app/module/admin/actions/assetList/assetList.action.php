<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\Model\AssetsComponent;

#[OModuleAction(
	url: '/asset-list',
	filters: ['admin'],
	services: ['admin']
)]
class assetListAction extends OAction {
	/**
	 * Función para obtener la lista de recursos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$assets_component = new AssetsComponent(['list' => $this->admin_service->getAssets()]);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $assets_component);
	}
}
