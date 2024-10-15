<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\UpdatePosition;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Game;

class UpdatePositionComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para guardar la última posición de un jugador
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_game     = $req->getParamInt('idGame');
		$x           = $req->getParamInt('x');
		$y           = $req->getParamInt('y');
		$orientation = $req->getParamString('orientation');

		if (is_null($id_game) || is_null($x) || is_null($y) || is_null($orientation)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$game->set('position_x',  $x);
				$game->set('position_y',  $y);
				$game->set('orientation', $orientation);
				$game->save();
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
