<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\GenerateMap;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Tools\OTools;

class GenerateMapAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para generar el mapa de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id = $req->getParamInt('id');

		if (is_null($id)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			OTools::runTask('map', [$id, 'true']);
		}
	}
}
