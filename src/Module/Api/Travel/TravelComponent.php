<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Travel;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\World;
use Osumi\OsumiFramework\App\Model\WorldUnlocked;

class TravelComponent extends OComponent {
  private ?WebService $ws = null;

  public string              $status   = 'ok';
  public string | int | null $id_world = null;

  public function __construct() {
    parent::__construct();
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para viajar a otro mundo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_game        = $req->getParamInt('idGame');
		$this->id_world = $req->getParamInt('idWorld');
		$word_one       = $req->getParamString('wordOne');
		$word_two       = $req->getParamString('wordTwo');
		$word_three     = $req->getParamString('wordThree');

		if (is_null($id_game) || is_null($word_one) || is_null($word_two) || is_null($word_three)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			// Si viene id es que es un mundo ya conocido
			if (!is_null($this->id_world)) {
				$world = new World();
				if (!$world->find(['id' => $this->id_world])) {
					$world = null;
				}
			}
			// Si no viene id es que está probando a ir a un mundo nuevo
			else {
				$world = $this->ws->getWorldByWords( strtolower($word_one), strtolower($word_two), strtolower($word_three));
			}

			if (!is_null($world)) {
				$this->id_world = $world->get('id');

				$world_unlocked = new WorldUnlocked();
				$world_unlocked->set('id_game', $id_game);
				$world_unlocked->set('id_world', $id_world);
				$world_unlocked->save();

				// TODO actualizar Game con la posición inicial del mundo al que va y orientation down
			}
			else {
				$this->status = 'error';
				$this->id_world = 'null';
			}
		}
	}
}
