<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteConnection;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;

class DeleteConnectionComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';

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
		$id_from     = $req->getParamInt('from');
		$id_to       = $req->getParamInt('to');
		$orientation = $req->getParamString('orientation');

		if (is_null($id_from) || is_null($id_to) || is_null($orientation)) {
			$this->status = 'error';
		}

    if ($this->status === 'ok') {
			$this->as->deleteConnection($id_from, $id_to, $orientation);
		}
	}
}
