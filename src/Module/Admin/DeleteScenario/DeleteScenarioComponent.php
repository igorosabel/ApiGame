<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteScenario;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Scenario;

class DeleteScenarioComponent extends OComponent {
  private ?AdminService $as = null;
  private ?WebService $ws = null;

  public string $status = 'ok';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para borrar un escenario
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
			$scenario = new Scenario();
			if ($scenario->find(['id' => $id])) {
				$origin_world = $this->ws->getOriginWorld();
				$this->as->deleteScenario($scenario, $origin_world);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
