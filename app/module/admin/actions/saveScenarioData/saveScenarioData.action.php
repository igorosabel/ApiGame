<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\ScenarioData;

#[OModuleAction(
	url: '/save-scenario-data',
	filter: 'admin'
)]
class saveScenarioDataAction extends OAction {
	/**
	 * Función para guardar el detalle de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status             = 'ok';
		$id                 = $req->getParamInt('id');
		$id_scenario        = $req->getParamInt('idScenario');
		$x                  = $req->getParamInt('x');
		$y                  = $req->getParamInt('y');
		$id_background      = $req->getParamInt('idBackground');
		$id_scenario_object = $req->getParamInt('idScenarioObject');
		$id_character       = $req->getParamInt('idCharacter');
		$character_health   = $req->getParamInt('characterHealth');

		if (is_null($id_scenario) || is_null($x) || is_null($y)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$scenario_data = new ScenarioData();
			if (!is_null($id)) {
				$scenario_data->find(['id' => $id]);
			}
			$scenario_data->set('id_scenario',        $id_scenario);
			$scenario_data->set('x',                  $x);
			$scenario_data->set('y',                  $y);
			$scenario_data->set('id_background',      $id_background);
			$scenario_data->set('id_scenario_object', $id_scenario_object);
			$scenario_data->set('id_character',       $id_character);
			$scenario_data->set('character_health',   $character_health);
			$scenario_data->save();

			$id = $scenario_data->get('id');
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
	}
}
