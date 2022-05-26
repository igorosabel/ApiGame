<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Background;

#[OModuleAction(
	url: '/save-background',
	filter: 'admin'
)]
class saveBackgroundAction extends OAction {
	/**
	 * Función para guardar un fondo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status                 = 'ok';
		$id                     = $req->getParamInt('id');
		$id_background_category = $req->getParamInt('idBackgroundCategory');
		$id_asset               = $req->getParamInt('idAsset');
		$name                   = $req->getParamString('name');
		$crossable              = $req->getParamBool('crossable');

		if (is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$background = new Background();
			if (!is_null($id)) {
				$background->find(['id'=>$id]);
			}
			$background->set('id_background_category', $id_background_category);
			$background->set('id_asset',               $id_asset);
			$background->set('name',                   $name);
			$background->set('crossable',              $crossable);
			$background->save();
		}

		$this->getTemplate()->add('status', $status);
	}
}
