<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\SaveScenarioData;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\ScenarioData;

class SaveScenarioDataAction extends OAction {
  public string     $status = 'ok';
  public int | null $id     = null;

	/**
	 * Función para guardar el detalle de un escenario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->id           = $req->getParamInt('id');
		$id_scenario        = $req->getParamInt('idScenario');
		$x                  = $req->getParamInt('x');
		$y                  = $req->getParamInt('y');
		$id_background      = $req->getParamInt('idBackground');
		$id_scenario_object = $req->getParamInt('idScenarioObject');
		$id_character       = $req->getParamInt('idCharacter');
		$character_health   = $req->getParamInt('characterHealth');

		if (is_null($id_scenario) || is_null($x) || is_null($y)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$scenario_data = new ScenarioData();
			if (!is_null($this->id)) {
				$scenario_data->find(['id' => $this->id]);
			}
			$scenario_data->set('id_scenario',        $id_scenario);
			$scenario_data->set('x',                  $x);
			$scenario_data->set('y',                  $y);
			$scenario_data->set('id_background',      $id_background);
			$scenario_data->set('id_scenario_object', $id_scenario_object);
			$scenario_data->set('id_character',       $id_character);
			$scenario_data->set('character_health',   $character_health);
			$scenario_data->save();

			$this->id = $scenario_data->get('id');
		}
	}
}
