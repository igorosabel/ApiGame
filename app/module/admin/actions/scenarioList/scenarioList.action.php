<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\ScenariosComponent;

#[OModuleAction(
	url: '/scenario-list',
	filter: 'admin',
	services: ['admin'],
	components: ['model/scenarios']
)]
class scenarioListAction extends OAction {
	/**
	 * Función para obtener la lista de escenarios
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$scenarios_component = new ScenariosComponent(['list' => []]);

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenarios_component->setValue('list', $this->admin_service->getScenarios($id));
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $scenarios_component);
	}
}
