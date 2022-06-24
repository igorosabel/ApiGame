<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\TagsComponent;

#[OModuleAction(
	url: '/tag-list',
	filters: ['admin'],
	services: ['admin'],
	components: ['model/tags']
)]
class tagListAction extends OAction {
	/**
	 * Función para obtener la lista de tags
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$tags_component = new TagsComponent(['list' => $this->admin_service->getTags()]);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $tags_component);
	}
}
