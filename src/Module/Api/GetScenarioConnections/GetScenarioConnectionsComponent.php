<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetScenarioConnections;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Scenario;
use Osumi\OsumiFramework\App\Component\Model\ConnectionList\ConnectionListComponent;

class GetScenarioConnectionsComponent extends OComponent {
  public string $status = 'ok';
  public ?ConnectionListComponent $list = null;

  public function __construct() {
    parent::__construct();
    $this->list = new ConnectionListComponent();
  }

	/**
	 * Función para obtener las conexiones de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id_scenario = $req->getParamInt('id');

		if (is_null($id_scenario)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$scenario = Scenario::findOne(['id' => $id_scenario]);
			if (!is_null($scenario)) {
				$this->list->list = $scenario->getConnections();
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
