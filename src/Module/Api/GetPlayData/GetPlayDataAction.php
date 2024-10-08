<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetPlayData;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Game;
use Osumi\OsumiFramework\App\Component\Game\Game\GameComponent;
use Osumi\OsumiFramework\App\Component\Game\Blockers\BlockersComponent;
use Osumi\OsumiFramework\App\Component\Model\ScenarioDataList\ScenarioDataListComponent;
use Osumi\OsumiFramework\App\Component\Model\ScenarioObjectList\ScenarioObjectListComponent;
use Osumi\OsumiFramework\App\Component\Model\CharacterList\CharacterListComponent;

class GetPlayDataAction extends OAction {
  public string       $status            = 'ok';
  public string | int $id_world          = 'null';
  public string       $world_name        = '';
  public string       $world_description = '';
  public string | int $id_scenario       = 'null';
  public string       $scenario_name     = '';
  public string       $map_url           = '';
  public ?BlockersComponent $blockers = null;
  public ?ScenarioDataListComponent $scenario_datas = null;
  public ?ScenarioObjectListComponent $scenario_objects = null;
  public ?CharacterListComponent $characters = null;
  public ?GameComponent $game = null;

  public function __construct() {
    $this->blockers         = new BlockersComponent(['list' => []]);
		$this->scenario_datas   = new ScenarioDataListComponent(['list' => []]);
		$this->scenario_objects = new ScenarioObjectListComponent(['list' => []]);
		$this->characters       = new CharacterListComponent(['list' => []]);
    $this->game             = new GameComponent(['Game' => null]);
  }

	/**
	 * Función para obtener los datos de una partida
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_game           = $req->getParamInt('id');
		$blockers          = [];
		$scenario_datas    = [];
		$scenario_objects  = [];
		$characters        = [];

		if (is_null($id_game)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$game = new Game();
			if ($game->find(['id' => $id_game])) {
				$scenario = $game->getScenario();
				$world    = $scenario->getWorld();

				$this->id_world          = $world->get('id');
				$this->world_name        = $world->get('name');
				$this->world_description = $world->get('description');
				$this->id_scenario       = $scenario->get('id');
				$this->scenario_name     = $scenario->get('name');
				$this->map_url           = $scenario->getMapUrl();

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
					if (!is_null($scenario_object) && $scenario_object->get('crossable') === false) {
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

				$this->blockers->setValue('list', $blockers);
				$this->scenario_datas->setValue('list', $scenario_datas);
				$this->scenario_objects->setValue('list', $scenario_objects);
				$this->characters->setValue('list', $characters);

				$this->game->setValue('Game', $game);
			}
			else {
				$this->status = 'error';
        $this->game->setValue('Game', null);
			}
		}
	}
}
