<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetScenarioConnections;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Scenario;
use Osumi\OsumiFramework\App\Component\Model\ConnectionList\ConnectionListComponent;

class GetScenarioConnectionsAction extends OAction {
  public string $status = 'ok';
  public ?ConnectionListComponent $list = null;

	/**
	 * Función para obtener las conexiones de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_scenario = $req->getParamInt('id');
		$this->list = new ConnectionListComponent(['list' => []]);

		if (is_null($id_scenario)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id_scenario])){
				$this->list->setValue('list', $scenario->getConnections());
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
