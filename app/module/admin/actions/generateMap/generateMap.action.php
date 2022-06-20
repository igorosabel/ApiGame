<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Tools\OTools;

#[OModuleAction(
	url: '/generate-map',
	filter: 'admin',
	services: ['admin']
)]
class generateMapAction extends OAction {
	/**
	 * Función para generar el mapa de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			OTools::runTask('map', [$id, 'true']);
		}

		$this->getTemplate()->add('status', $status);
	}
}
