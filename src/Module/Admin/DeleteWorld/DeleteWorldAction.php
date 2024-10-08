<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteWorld;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\World;

class DeleteWorldAction extends OAction {
  private ?AdminService $as = null;
  private ?WebService $ws = null;

  public string $status = 'ok';

  public function __construct() {
    $this->as = inject(AdminService::class);
    $this->ws = inject(WebService::class);
  }

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

		if ($this->status === 'ok') {
			$world = new World();
			if ($world->find(['id' => $id])) {
				$origin_world = $this->ws->getOriginWorld();
				$this->as->deleteWorld($world, $origin_world);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
