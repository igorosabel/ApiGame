<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetGames;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Game\Games\GamesComponent;

class GetGamesAction extends OAction {
  public string $status = 'ok';
  public ?GamesComponent $list = null;

	/**
	 * Función para obtener la lista de partidas de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$filter = $req->getFilter('Game');
		$games  = $this->service['Web']->getGames($filter['id']);
		$this->list = new GamesComponent(['list' => $games]);
	}
}
