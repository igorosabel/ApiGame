<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\ScenarioList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Component\Model\ScenarioList\ScenarioListComponent;

class ScenarioListAction extends OAction {
  private ?AdminService $as = null;

  public string $status = 'ok';
  public ?ScenarioListComponent $list = null;

  public function __construct() {
    $this->as = inject(AdminService::class);
    $this->list = new ScenarioListComponent(['list' => []]);
  }

	/**
	 * Función para obtener la lista de escenarios
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id = $req->getParamInt('id');

		if (is_null($id)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->list->setValue('list', $this->as->getScenarios($id));
		}
	}
}
