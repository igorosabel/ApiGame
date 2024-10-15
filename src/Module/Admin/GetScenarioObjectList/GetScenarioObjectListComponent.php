<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\GetScenarioObjectList;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Component\Model\ScenarioObjectList\ScenarioObjectListComponent;

class GetScenarioObjectListComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';
  public ?ScenarioObjectListComponent $list = null;

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para obtener la lista de objetos de escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new ScenarioObjectListComponent(['list' => $this->as->getScenarioObjects()]);
	}
}
