<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetUnlockedWorlds;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\WorldList\WorldListComponent;

class GetUnlockedWorldsAction extends OAction {
  public string $status = 'ok';
  public ?WorldListComponent $list = null;

	/**
	 * Función para obtener los mundos que un jugador a desbloqueado
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_game = $req->getParamInt('id');
		$this->list = new WorldListComponent(['list' => []]);

		if (is_null($id_game)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$this->list->setValue('list', $this->service['Web']->getUnlockedWorlds($id_game));
		}
	}
}
