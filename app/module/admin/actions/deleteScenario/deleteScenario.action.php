<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Scenario;

#[OModuleAction(
	url: '/delete-scenario',
	filter: 'admin',
	services: ['web', 'admin']
)]
class deleteScenarioAction extends OAction {
	/**
	 * Función para borrar un escenario
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
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id])) {
				$origin_world = $this->web_service->getOriginWorld();
				$this->admin_service->deleteScenario($scenario, $origin_world);
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
