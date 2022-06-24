<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Game;
use OsumiFramework\App\Component\GameComponent;
use OsumiFramework\App\Component\BlockersComponent;
use OsumiFramework\App\Component\ScenarioDatasComponent;
use OsumiFramework\App\Component\ScenarioObjectsComponent;
use OsumiFramework\App\Component\CharactersComponent;

#[OModuleAction(
	url: '/get-play-data',
	filters: ['game'],
	components: ['game/game', 'game/blockers', 'model/scenario_datas', 'model/scenario_objects', 'model/characters']
)]
class getPlayDataAction extends OAction {
	/**
	 * Función para obtener los datos de una partida
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status            = 'ok';
		$id_game           = $req->getParamInt('id');
		$id_world          = 'null';
		$world_name        = '';
		$world_description = '';
		$id_scenario       = 'null';
		$scenario_name     = '';
		$map_url           = '';
		$blockers          = [];
		$scenario_datas    = [];
		$scenario_objects  = [];
		$characters        = [];
		$blockers_component         = new BlockersComponent(['list' => []]);
		$scenario_datas_component   = new ScenarioDatasComponent(['list' => []]);
		$scenario_objects_component = new ScenarioObjectsComponent(['list' => []]);
		$characters_component       = new CharactersComponent(['list' => []]);

		if (is_null($id_game)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$scenario = $game->getScenario();
				$world    = $scenario->getWorld();

				$id_world          = $world->get('id');
				$world_name        = $world->get('name');
				$world_description = $world->get('description');
				$id_scenario       = $scenario->get('id');
				$scenario_name     = $scenario->get('name');
				$map_url           = $scenario->getMapUrl();

				$data = $scenario->getData();
				$in_scenario_objects = [];
				$in_characters = [];
				foreach ($data as $scenario_data) {
					$in_datas   = false;
					$background = $scenario_data->getBackground();
					if (!$background->get('crossable')) {
						array_push($blockers, ['x' => $scenario_data->get('x'), 'y' => $scenario_data->get('y')]);
					}
					$scenario_object = $scenario_data->getScenarioObject();
					if (!is_null($scenario_object) && $scenario_object->get('crossable')===false) {
						array_push($blockers, ['x' => $scenario_data->get('x'), 'y' => $scenario_data->get('y')]);
						if (!in_array($scenario_object->get('id'), $in_scenario_objects)) {
							array_push($scenario_objects, $scenario_object);
							array_push($in_scenario_objects, $scenario_object->get('id'));
						}
						array_push($scenario_datas, $scenario_data);
						$in_datas = true;
					}
					$character = $scenario_data->getCharacter();
					if (!is_null($character)) {
						if (!in_array($character->get('id'), $in_characters)) {
							array_push($characters, $character);
							array_push($in_characters, $character->get('id'));
						}
						if (!$in_datas) {
							array_push($scenario_datas, $scenario_data);
						}
					}
				}

				$blockers_component->setValue('list', $blockers);
				$scenario_datas_component->setValue('list', $scenario_datas);
				$scenario_objects_component->setValue('list', $scenario_objects);
				$characters_component->setValue('list', $characters);

				$game_component = new GameComponent(['game' => $game]);
				$this->getTemplate()->add('game', $game_component);
			}
			else {
				$status = 'error';
				$this->getTemplate()->add('game', 'null');
			}
		}

		$this->getTemplate()->add('status',            $status);
		$this->getTemplate()->add('id_world',          $id_world);
		$this->getTemplate()->add('world_name',        $world_name);
		$this->getTemplate()->add('world_description', $world_description);
		$this->getTemplate()->add('id_scenario',       $id_scenario);
		$this->getTemplate()->add('scenario_name',     $scenario_name);
		$this->getTemplate()->add('map_url',           $map_url);
		$this->getTemplate()->add('blockers',          $blockers_component);
		$this->getTemplate()->add('scenario_datas',    $scenario_datas_component);
		$this->getTemplate()->add('scenario_objects',  $scenario_objects_component);
		$this->getTemplate()->add('characters',        $characters_component);
	}
}
