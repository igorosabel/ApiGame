<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetUnlockedWorlds;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Component\Model\WorldList\WorldListComponent;

class GetUnlockedWorldsAction extends OAction {
  private ?WebService $ws = null;

  public string $status = 'ok';
  public ?WorldListComponent $list = null;

  public function __construct() {
    $this->ws = inject(WebService::class);
    $this->list = new WorldListComponent(['list' => []]);
  }

	/**
	 * Función para obtener los mundos que un jugador a desbloqueado
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_game = $req->getParamInt('id');

		if (is_null($id_game)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->list->setValue('list', $this->ws->getUnlockedWorlds($id_game));
		}
	}
}
