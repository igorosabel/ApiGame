<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\ItemsComponent;

#[OModuleAction(
	url: '/item-list',
	filter: 'admin',
	services: 'admin',
	components: 'model/items'
)]
class itemListAction extends OAction {
	/**
	 * Función para obtener la lista de items
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$items_component = new ItemsComponent(['list' => $this->admin_service->getItems(), 'extra' => 'nourlencode']);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $items_component);
	}
}
