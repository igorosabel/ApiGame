<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteWorld;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\World;

class DeleteWorldComponent extends OComponent {
  private ?AdminService $as = null;
  private ?WebService $ws = null;

  public string $status = 'ok';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para borrar un mundo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id = $req->getParamInt('id');

		if (is_null($id)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$world = World::findOne(['id' => $id]);
			if (!is_null($world)) {
				$origin_world = $this->ws->getOriginWorld();
				$this->as->deleteWorld($world, $origin_world);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
