<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetGames;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Component\Game\Games\GamesComponent;

class GetGamesComponent extends OComponent {
  private ?WebService $ws = null;

  public string $status = 'ok';
  public ?GamesComponent $list = null;

  public function __construct() {
    parent::__construct();
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para obtener la lista de partidas de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$filter = $req->getFilter('Game');
		$games  = $this->ws->getGames($filter['id']);
		$this->list = new GamesComponent(['list' => $games]);
	}
}
