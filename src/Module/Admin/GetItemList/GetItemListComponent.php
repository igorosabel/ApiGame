<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\GetItemList;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Component\Model\ItemList\ItemListComponent;

class GetItemListComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';
  public ?ItemListComponent $list = null;

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para obtener la lista de items
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new ItemListComponent(['list' => $this->as->getItems()]);
	}
}
