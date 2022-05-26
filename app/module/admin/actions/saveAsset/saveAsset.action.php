<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Asset;

#[OModuleAction(
	url: '/save-asset',
	filter: 'admin',
	services: 'admin'
)]
class saveAssetAction extends OAction {
	/**
	 * Función para guardar un recurso
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status   = 'ok';
		$id       = $req->getParamInt('id');
		$id_world = $req->getParamInt('id_world');
		$name     = $req->getParamString('name');
		$url      = $req->getParamString('url');
		$tags     = $req->getParamString('tagList');

		if (is_null($name)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$ext = null;
			$asset = new Asset();
			if (!is_null($id)) {
				$asset->find(['id' => $id]);
				$ext = $asset->get('ext');
			}
			if (!is_null($url)) {
				$ext = $this->admin_service->getFileExt($url);
			}
			$asset->set('id_world', $id_world);
			$asset->set('name',     $name);
			$asset->set('ext',      $ext);
			$asset->save();

			if (!is_null($url)) {
				$this->admin_service->saveAssetImage($asset, $url);
			}

			if (!is_null($tags) && $tags!='') {
				$this->admin_service->updateAssetTags($asset, $tags);
			}
			else {
				$this->admin_service->cleanAssetTags($asset);
				$this->admin_service->cleanUnnusedTags();
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
