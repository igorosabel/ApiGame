<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\BackgroundCategory;

#[OModuleAction(
	url: '/delete-background-category',
	filter: 'admin',
	services: 'admin'
)]
class deleteBackgroundCategoryAction extends OAction {
	/**
	 * Función para borrar una categoría de fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$message = '';

		if (is_null($id)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$background_category = new BackgroundCategory();
			if ($background_category->find(['id'=>$id])) {
				$return  = $this->admin_service->deleteBackgroundCategory($background_category);
				$status  = $return['status'];
				$message = $return['message'];
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message);
	}
}
