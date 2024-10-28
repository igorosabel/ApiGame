<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetPlayData;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Game;
use Osumi\OsumiFramework\App\Component\Game\Game\GameComponent;
use Osumi\OsumiFramework\App\Component\Game\Blockers\BlockersComponent;
use Osumi\OsumiFramework\App\Component\Model\ScenarioDataList\ScenarioDataListComponent;
use Osumi\OsumiFramework\App\Component\Model\ScenarioObjectList\ScenarioObjectListComponent;
use Osumi\OsumiFramework\App\Component\Model\CharacterList\CharacterListComponent;

class GetPlayDataComponent extends OComponent {
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
    parent::__construct();
    $this->blockers         = new BlockersComponent();
		$this->scenario_datas   = new ScenarioDataListComponent();
		$this->scenario_objects = new ScenarioObjectListComponent();
		$this->characters       = new CharacterListComponent();
    $this->game             = new GameComponent();
  }

	/**
	 * Función para obtener los datos de una partida
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id_game           = $req->getParamInt('id');
		$blockers          = [];
		$scenario_datas    = [];
		$scenario_objects  = [];
		$characters        = [];

		if (is_null($id_game)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$game = Game::findOne(['id' => $id_game]);
			if (!is_null($game)) {
				$scenario = $game->getScenario();
				$world    = $scenario->getWorld();

				$this->id_world          = $world->id;
				$this->world_name        = $world->name;
				$this->world_description = $world->description;
				$this->id_scenario       = $scenario->id;
				$this->scenario_name     = $scenario->name;
				$this->map_url           = $scenario->getMapUrl();

				$data = $scenario->getData();
				$in_scenario_objects = [];
				$in_characters = [];
				foreach ($data as $scenario_data) {
					$in_datas   = false;
					$background = $scenario_data->getBackground();
					if (!$background->crossable) {
						$blockers[] = ['x' => $scenario_data->x, 'y' => $scenario_data->y];
					}
					$scenario_object = $scenario_data->getScenarioObject();
					if (!is_null($scenario_object) && $scenario_object->crossable === false) {
						$blockers[] = ['x' => $scenario_data->x, 'y' => $scenario_data->y];
						if (!in_array($scenario_object->id, $in_scenario_objects)) {
							$scenario_objects[] = $scenario_object;
							$in_scenario_objects[] = $scenario_object->id;
						}
						$scenario_datas[] = $scenario_data;
						$in_datas = true;
					}
					$character = $scenario_data->getCharacter();
					if (!is_null($character)) {
						if (!in_array($character->id, $in_characters)) {
							$characters[] = $character;
							$in_characters[] = $character->id;
						}
						if (!$in_datas) {
							$scenario_datas[] = $scenario_data;
						}
					}
				}

				$this->blockers->list = $blockers;
				$this->scenario_datas->list = $scenario_datas;
				$this->scenario_objects->list = $scenario_objects;
				$this->characters->list = $characters;

				$this->game->game = $game;
			}
			else {
				$this->status = 'error';
        $this->game->game = null;
			}
		}
	}
}
