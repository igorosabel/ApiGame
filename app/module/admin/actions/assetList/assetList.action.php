<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\AssetsComponent;

#[OModuleAction(
	url: '/asset-list',
	filter: 'admin',
	services: 'admin',
	components: 'model/assets'
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
		$assets_component = new AssetsComponent(['list' => $this->admin_service->getAssets(), 'extra' => 'nourlencode']);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $assets_component);
	}
}
