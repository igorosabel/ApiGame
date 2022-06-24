<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\ScenarioObjectsComponent;

#[OModuleAction(
	url: '/scenario-object-list',
	filters: ['admin'],
	services: ['admin'],
	components: ['model/scenario_objects']
)]
class scenarioObjectListAction extends OAction {
	/**
	 * Función para obtener la lista de objetos de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$scenario_objects_component = new ScenarioObjectsComponent(['list' => $this->admin_service->getScenarioObjects()]);

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $scenario_objects_component);
	}
}
