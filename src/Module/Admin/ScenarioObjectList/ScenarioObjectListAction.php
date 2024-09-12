<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\ScenarioObjectList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\ScenarioObjectList\ScenarioObjectListComponent;

class ScenarioObjectListAction extends OAction {
  public string $status = 'ok';
  public ?ScenarioObjectListComponent $list = null;

	/**
	 * Función para obtener la lista de objetos de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new ScenarioObjectListComponent(['list' => $this->service['Admin']->getScenarioObjects()]);
	}
}
