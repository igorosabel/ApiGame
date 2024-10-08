<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\CharacterList;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Component\Model\CharacterList\CharacterListComponent;

class CharacterListAction extends OAction {
  private ?AdminService $as = null;

  public string $status = 'ok';
  public ?CharacterListComponent $list = null;

  public function __construct() {
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para obtener la lista de personajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->list = new CharacterListComponent(['list' => $this->as->getCharacters()]);
	}
}
