<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveConnection;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;

class SaveConnectionAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para guardar una conexión de un escenario a otro
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_from     = $req->getParamInt('from');
		$id_to       = $req->getParamInt('to');
		$orientation = $req->getParamString('orientation');

		if (is_null($id_from) || is_null($id_to) || is_null($orientation)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$this->service['Admin']->updateConnection($id_from, $id_to, $orientation);
		}
	}
}
