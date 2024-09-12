<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveScenario;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Scenario;

class SaveScenarioAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para guardar un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id       = $req->getParamInt('id');
		$id_world = $req->getParamInt('idWorld');
		$name     = $req->getParamString('name');
		$friendly = $req->getParamBool('friendly');

		if (is_null($name) || is_null($id_world) || is_null($friendly)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$scenario = new Scenario();
			if (!is_null($id)) {
				$scenario->find(['id' => $id]);
			}
			$scenario->set('id_world', $id_world);
			$scenario->set('name',     $name);
			$scenario->set('friendly', $friendly);

			$scenario->save();
		}
	}
}
