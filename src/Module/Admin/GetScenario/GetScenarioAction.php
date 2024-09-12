<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\GetScenario;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Scenario;
use Osumi\OsumiFramework\App\Component\Model\Scenario\ScenarioComponent;
use Osumi\OsumiFramework\App\Component\Model\ScenarioDataList\ScenarioDataListComponent;
use Osumi\OsumiFramework\App\Component\Model\ConnectionList\ConnectionListComponent;

class GetScenarioAction extends OAction {
  public string $status = 'ok';
  public ?ScenarioComponent         $scenario   = null;
  public ?ScenarioDataListComponent $data       = null;
  public ?ConnectionListComponent   $connection = null;

	/**
	 * Función para obtener el detalle de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
    $id = $req->getParamInt('id');
		$this->scenario   = new ScenarioComponent(['Scenario' => null]);
		$this->data       = new ScenarioDataListComponent(['list' => []]);
		$this->connection = new ConnectionListComponent(['list' => []]);

		$scenario = new Scenario();
		if ($scenario->find(['id' => $id])) {
			$this->scenario->setValue('Scenario', $scenario);
			$this->data->setValue('list', $scenario->getData());
			$this->connection->setValue('list', $scenario->getConnections());
		}
		else {
			$this->status = 'error';
		}
	}
}
