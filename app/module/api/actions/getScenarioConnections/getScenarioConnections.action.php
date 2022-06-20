<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Scenario;
use OsumiFramework\App\Component\ConnectionsComponent;

#[OModuleAction(
	url: '/get-scenario-connections',
	filter: 'game',
	components: ['model/connections']
)]
class getScenarioConnectionsAction extends OAction {
	/**
	 * Función para obtener las conexiones de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status      = 'ok';
		$id_scenario = $req->getParamInt('id');
		$connecions_component = new ConnectionsComponent(['list' => []]);

		if (is_null($id_scenario)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id_scenario])){
				$connecions_component->setValue('list', $scenario->getConnections());
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $connecions_component);
	}
}
