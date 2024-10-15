<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteBackgroundCategory;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Model\BackgroundCategory;

class DeleteBackgroundCategoryComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status  = 'ok';
  public string $message = '';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para borrar una categoría de fondo
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
			$background_category = new BackgroundCategory();
			if ($background_category->find(['id' => $id])) {
				$return  = $this->as->deleteBackgroundCategory($background_category);
				$this->status  = $return['status'];
				$this->message = $return['message'];
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
