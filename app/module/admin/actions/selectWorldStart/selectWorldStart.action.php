<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Scenario;

#[OModuleAction(
	url: '/select-world-start',
	filter: 'admin',
	services: 'admin'
)]
class selectWorldStartAction extends OAction {
	/**
	 * Función para borrar una conexión de un escenario a otro
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status      = 'ok';
		$id_scenario = $req->getParamInt('idScenario');
		$x           = $req->getParamInt('x');
		$y           = $req->getParamInt('y');
		$check       = $req->getParamBool('check');
		$message      = '';

		if (is_null($id_scenario) || is_null($x) || is_null($y) || is_null($check)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id_scenario])) {
				if ($check) {
					$result  = $this->admin_service->checkWorldStart($scenario);
					$status  = $result['status'];
					$message = $result['message'];
				}
				if ($status=='ok') {
					$this->admin_service->clearWorldStart($scenario);
					$scenario->set('start_x', $x);
					$scenario->set('start_y', $y);
					$scenario->set('initial', true);
					$scenario->save();
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}
}
