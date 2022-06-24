<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;

#[OModuleAction(
	url: '/save-connection',
	filters: ['admin'],
	services: ['admin']
)]
class saveConnectionAction extends OAction {
	/**
	 * Función para guardar una conexión de un escenario a otro
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status      = 'ok';
		$id_from     = $req->getParamInt('from');
		$id_to       = $req->getParamInt('to');
		$orientation = $req->getParamString('orientation');

		if (is_null($id_from) || is_null($id_to) || is_null($orientation)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$this->admin_service->updateConnection($id_from, $id_to, $orientation);
		}

		$this->getTemplate()->add('status', $status);
	}
}
