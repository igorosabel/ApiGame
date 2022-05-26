<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Scenario;
use OsumiFramework\App\Component\ScenarioComponent;
use OsumiFramework\App\Component\ScenarioDatasComponent;
use OsumiFramework\App\Component\ConnectionsComponent;

#[OModuleAction(
	url: '/get-scenario',
	filter: 'admin',
	components: 'model/scenario, model/scenario_datas, model/connections'
)]
class getScenarioAction extends OAction {
	/**
	 * Función para obtener el detalle de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');

		$scenario_component       = new ScenarioComponent(['sce' => null, 'extra' => 'nourlencode']);
		$scenario_datas_component = new ScenarioDatasComponent(['list' => [], 'extra' => 'nourlencode']);
		$connections_component    = new ConnectionsComponent(['list' => [], 'extra' => 'nourlencode']);

		$scenario = new Scenario();
		if ($scenario->find(['id' => $id])) {
			$scenario_component       = new ScenarioComponent(['sce' => $scenario, 'extra' => 'nourlencode']);
			$scenario_datas_component = new ScenarioDatasComponent(['list' => $scenario->getData(), 'extra' => 'nourlencode']);
			$connections_component    = new ConnectionsComponent(['list' => $scenario->getConnections(), 'extra' => 'nourlencode']);
		}
		else {
			$status = 'error';
		}

		$this->getTemplate()->add('status',     $status);
		$this->getTemplate()->add('scenario',   $scenario_component);
		$this->getTemplate()->add('data',       $scenario_datas_component);
		$this->getTemplate()->add('connection', $connections_component);
	}
}
