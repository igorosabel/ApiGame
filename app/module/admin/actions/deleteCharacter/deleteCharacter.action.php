<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;

#[OModuleAction(
	url: '/delete-character',
	filter: 'admin',
	services: ['admin']
)]
class deleteCharacterAction extends OAction {
	/**
	 * Función para borrar un personaje
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$return  = $this->admin_service->deleteCharacter($id);
			$status  = $return['status'];
			$message = $return['message'];
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}
}
