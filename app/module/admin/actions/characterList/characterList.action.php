<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\Model\CharactersComponent;

#[OModuleAction(
	url: '/character-list',
	filters: ['admin'],
	services: ['admin']
)]
class characterListAction extends OAction {
	/**
	 * Función para obtener la lista de personajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$characters_component = new CharactersComponent(['list' => $this->admin_service->getCharacters()]);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $characters_component);
	}
}
