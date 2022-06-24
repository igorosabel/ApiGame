<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\BackgroundCategoryListComponent;

#[OModuleAction(
	url: '/background-category-list',
	filters: ['admin'],
	services: ['admin'],
	components: ['model/backgroundcategory_list']
)]
class backgroundCategoryListAction extends OAction {
	/**
	 * Función para obtener la lista de categorías de fondos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$background_list_categoeries_component = new BackgroundCategoryListComponent(['list' => $this->admin_service->getBackgroundCategories()]);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $background_list_categoeries_component);
	}
}
