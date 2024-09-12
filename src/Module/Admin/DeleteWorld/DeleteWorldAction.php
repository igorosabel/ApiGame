<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteWorld;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\World;

class DeleteWorldAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para borrar un mundo
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
			$world = new World();
			if ($world->find(['id' => $id])) {
				$origin_world = $this->service['Web']->getOriginWorld();
				$this->service['Admin']->deleteWorld($world, $origin_world);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
