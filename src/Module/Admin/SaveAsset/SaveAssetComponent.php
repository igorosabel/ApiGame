<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveAsset;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Model\Asset;

class SaveAssetComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

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

		if ($this->status === 'ok') {
			$ext = null;
			$asset = new Asset();
			if (!is_null($id)) {
				$asset->find(['id' => $id]);
				$ext = $asset->get('ext');
			}
			if (!is_null($url)) {
				$ext = $this->as->getFileExt($url);
			}
			$asset->set('id_world', $id_world);
			$asset->set('name',     $name);
			$asset->set('ext',      $ext);
			$asset->save();

			if (!is_null($url)) {
				$this->as->saveAssetImage($asset, $url);
			}

			if (!is_null($tags) && $tags !== '') {
				$this->as->updateAssetTags($asset, $tags);
			}
			else {
				$this->as->cleanAssetTags($asset);
				$this->as->cleanUnnusedTags();
			}
		}
	}
}
