<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Scenario;

#[OModuleAction(
	url: '/save-scenario',
	filters: ['admin']
)]
class saveScenarioAction extends OAction {
	/**
	 * Función para guardar un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status   = 'ok';
		$id       = $req->getParamInt('id');
		$id_world = $req->getParamInt('idWorld');
		$name     = $req->getParamString('name');
		$friendly = $req->getParamBool('friendly');

		if (is_null($name) || is_null($id_world) || is_null($friendly)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if (!is_null($id)) {
				$scenario->find(['id' => $id]);
			}
			$scenario->set('id_world', $id_world);
			$scenario->set('name',     $name);
			$scenario->set('friendly', $friendly);

			$scenario->save();
		}

		$this->getTemplate()->add('status', $status);
	}
}
