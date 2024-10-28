<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\GetScenario;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Scenario;
use Osumi\OsumiFramework\App\Component\Model\Scenario\ScenarioComponent;
use Osumi\OsumiFramework\App\Component\Model\ScenarioDataList\ScenarioDataListComponent;
use Osumi\OsumiFramework\App\Component\Model\ConnectionList\ConnectionListComponent;

class GetScenarioComponent extends OComponent {
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
	public function run(ORequest $req): void {
    $id = $req->getParamInt('id');
		$this->scenario   = new ScenarioComponent();
		$this->data       = new ScenarioDataListComponent();
		$this->connection = new ConnectionListComponent();

		$scenario = Scenario::findOne(['id' => $id]);
		if (!is_null($scenario)) {
			$this->scenario->scenario = $scenario;
			$this->data->list = $scenario->getData();
			$this->connection->list = $scenario->getConnections();
		}
		else {
			$this->status = 'error';
		}
	}
}
