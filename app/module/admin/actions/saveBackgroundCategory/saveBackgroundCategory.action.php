<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\BackgroundCategory;

#[OModuleAction(
	url: '/save-background-category',
	filter: 'admin'
)]
class saveBackgroundCategoryAction extends OAction {
	/**
	 * Función para guardar una categoría de fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$name   = $req->getParamString('name');

		if (is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$background_category = new BackgroundCategory();
			if (!is_null($id)) {
				$background_category->find(['id' => $id]);
			}
			$background_category->set('name', $name);
			$background_category->save();
		}

		$this->getTemplate()->add('status', $status);
	}
}
