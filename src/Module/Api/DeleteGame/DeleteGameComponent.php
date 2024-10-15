<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\DeleteGame;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Game;

class DeleteGameComponent extends OComponent {
  private ?WebService $ws = null;

  public string $status  = 'ok';

  public function __construct() {
    parent::__construct();
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para borrar una partida
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
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$this->ws->deleteGame($game);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
