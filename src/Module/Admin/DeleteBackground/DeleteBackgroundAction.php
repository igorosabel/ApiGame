<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteBackground;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Model\Background;

class DeleteBackgroundAction extends OAction {
  private ?AdminService $as = null;

  public string $status  = 'ok';
  public string $message = '';

  public function __construct() {
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para borrar un fondo
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
			$background = new Background();
			if ($background->find(['id' => $id])) {
				$return = $this->as->deleteBackground($background);
				$this->status  = $return['status'];
				$this->message = $return['message'];
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
