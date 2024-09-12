<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\DeleteItem;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;

class DeleteItemAction extends OAction {
  public string $status  = 'ok';
  public string $message = '';

	/**
	 * Función para borrar un item
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
			$return  = $this->service['Admin']->deleteItem($id);
			$this->status  = $return['status'];
			$this->message = $return['message'];
		}
	}
}
