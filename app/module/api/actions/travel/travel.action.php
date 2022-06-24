<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\World;
use OsumiFramework\App\Model\WorldUnlocked;

#[OModuleAction(
	url: '/travel',
	filters: ['game'],
	services: ['web']
)]
class travelAction extends OAction {
	/**
	 * Función para viajar a otro mundo
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status     = 'ok';
		$id_game    = $req->getParamInt('idGame');
		$id_world   = $req->getParamInt('idWorld');
		$word_one   = $req->getParamString('wordOne');
		$word_two   = $req->getParamString('wordTwo');
		$word_three = $req->getParamString('wordThree');

		if (is_null($id_game) || is_null($word_one) || is_null($word_two) || is_null($word_three)) {
			$status = 'error';
		}

		if ($status=='ok') {
			// Si viene id es que es un mundo ya conocido
			if (!is_null($id)) {
				$world = new World();
				if (!$world->find(['id' => $id])) {
					$world = null;
				}
			}
			// Si no viene id es que está probando a ir a un mundo nuevo
			else {
				$world = $this->web_service->getWorldByWords( strtolower($word_one), strtolower($word_two), strtolower($word_three));
			}

			if (!is_null($world)) {
				$id_world = $world->get('id');

				$world_unlocked = new WorldUnlocked();
				$world_unlocked->set('id_game', $id_game);
				$world_unlocked->set('id_world', $id_world);
				$world_unlocked->save();

				// TODO actualizar Game con la posición inicial del mundo al que va y orientation down
			}
			else {
				$status = 'error';
				$id_world = 'null';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id_world);
	}
}
