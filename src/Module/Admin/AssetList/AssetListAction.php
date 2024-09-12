<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\AssetList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\AssetList\AssetListComponent;

class AssetListAction extends OAction {
  public string $status = 'ok';
  public ?AssetListComponent $list = null;

	/**
	 * Función para obtener la lista de recursos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new AssetListComponent(['list' => $this->service['Admin']->getAssets()]);
	}
}
