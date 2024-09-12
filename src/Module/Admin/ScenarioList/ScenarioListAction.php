<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\ScenarioList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\ScenarioList\ScenarioListComponent;

class ScenarioListAction extends OAction {
  public string $status = 'ok';
  public ?ScenarioListComponent $list = null;

	/**
	 * Función para obtener la lista de escenarios
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id = $req->getParamInt('id');
		$this->list = new ScenarioListComponent(['list' => []]);

		if (is_null($id)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$this->list->setValue('list', $this->service['Admin']->getScenarios($id));
		}
	}
}
