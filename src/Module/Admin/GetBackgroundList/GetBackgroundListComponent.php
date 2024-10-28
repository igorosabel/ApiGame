<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\GetBackgroundList;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Component\Model\BackgroundList\BackgroundListComponent;

class GetBackgroundListComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';
  public ?BackgroundListComponent $list = null;

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para obtener la lista de fondos
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$this->list = new BackgroundListComponent(['list' => $this->as->getBackgrounds()]);
	}
}
