<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\GetTagList;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent;

class GetTagListComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';
  public ?TagListComponent $list = null;

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para obtener la lista de tags
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$this->list = new TagListComponent(['list' => $this->as->getTags()]);
	}
}
