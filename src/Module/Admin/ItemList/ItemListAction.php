<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\ItemList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\ItemList\ItemListComponent;

class ItemListAction extends OAction {
  public string $status = 'ok';
  public ?ItemListComponent $list = null;

	/**
	 * Función para obtener la lista de items
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new ItemListComponent(['list' => $this->service['Admin']->getItems()]);
	}
}
