<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveAsset;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Asset;

class SaveAssetAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para guardar un recurso
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id       = $req->getParamInt('id');
		$id_world = $req->getParamInt('id_world');
		$name     = $req->getParamString('name');
		$url      = $req->getParamString('url');
		$tags     = $req->getParamString('tagList');

		if (is_null($name)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$ext = null;
			$asset = new Asset();
			if (!is_null($id)) {
				$asset->find(['id' => $id]);
				$ext = $asset->get('ext');
			}
			if (!is_null($url)) {
				$ext = $this->service['Admin']->getFileExt($url);
			}
			$asset->set('id_world', $id_world);
			$asset->set('name',     $name);
			$asset->set('ext',      $ext);
			$asset->save();

			if (!is_null($url)) {
				$this->service['Admin']->saveAssetImage($asset, $url);
			}

			if (!is_null($tags) && $tags!='') {
				$this->service['Admin']->updateAssetTags($asset, $tags);
			}
			else {
				$this->service['Admin']->cleanAssetTags($asset);
				$this->service['Admin']->cleanUnnusedTags();
			}
		}
	}
}
