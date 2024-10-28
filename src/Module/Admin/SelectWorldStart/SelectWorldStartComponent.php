<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SelectWorldStart;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Model\Scenario;

class SelectWorldStartComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status  = 'ok';
  public string $message = '';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para borrar una conexión de un escenario a otro
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id_scenario = $req->getParamInt('idScenario');
		$x           = $req->getParamInt('x');
		$y           = $req->getParamInt('y');
		$check       = $req->getParamBool('check');

		if (is_null($id_scenario) || is_null($x) || is_null($y) || is_null($check)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$scenario = Scenario::findOne(['id' => $id_scenario]);
			if (!is_null($scenario)) {
				if ($check) {
					$result  = $this->as->checkWorldStart($scenario);
					$this->status  = $result['status'];
					$this->message = $result['message'];
				}
				if ($this->status === 'ok') {
					$this->as->clearWorldStart($scenario);
					$scenario->start_x = $x;
					$scenario->start_y = $y;
					$scenario->initial = true;
					$scenario->save();
				}
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
