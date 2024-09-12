<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\BackgroundCategoryList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\BackgroundCategoryList\BackgroundCategoryListComponent;

class BackgroundCategoryListAction extends OAction {
  public string $status = 'ok';
  public ?BackgroundCategoryListComponent $list = null;

	/**
	 * Función para obtener la lista de categorías de fondos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new BackgroundCategoryListComponent(['list' => $this->service['Admin']->getBackgroundCategories()]);
	}
}
