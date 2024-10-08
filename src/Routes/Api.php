<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Module\Api\ChangeScenario\ChangeScenarioAction;
use Osumi\OsumiFramework\App\Module\Api\DeleteGame\DeleteGameAction;
use Osumi\OsumiFramework\App\Module\Api\GetGames\GetGamesAction;
use Osumi\OsumiFramework\App\Module\Api\GetPlayData\GetPlayDataAction;
use Osumi\OsumiFramework\App\Module\Api\GetScenarioConnections\GetScenarioConnectionsAction;
use Osumi\OsumiFramework\App\Module\Api\GetUnlockedWorlds\GetUnlockedWorldsAction;
use Osumi\OsumiFramework\App\Module\Api\HitEnemy\HitEnemyAction;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginAction;
use Osumi\OsumiFramework\App\Module\Api\NewGame\NewGameAction;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterAction;
use Osumi\OsumiFramework\App\Module\Api\Travel\TravelAction;
use Osumi\OsumiFramework\App\Module\Api\UpdatePosition\UpdatePositionAction;
use Osumi\OsumiFramework\App\Filter\GameFilter;

ORoute::group('/api', 'json', function() {
  ORoute::post('/change-scenario',          ChangeScenarioAction::class,         [GameFilter::class]);
  ORoute::post('/delete-game',              DeleteGameAction::class,             [GameFilter::class]);
  ORoute::post('/get-games',                GetGamesAction::class,               [GameFilter::class]);
  ORoute::post('/get-play-data',            GetPlayDataAction::class,            [GameFilter::class]);
  ORoute::post('/get-scenario-connections', GetScenarioConnectionsAction::class, [GameFilter::class]);
  ORoute::post('/get-unlocked-worlds',      GetUnlockedWorldsAction::class,      [GameFilter::class]);
  ORoute::post('/hit-enemy',                HitEnemyAction::class,               [GameFilter::class]);
  ORoute::post('/login',                    LoginAction::class);
  ORoute::post('/new-game',                 NewGameAction::class,                [GameFilter::class]);
  ORoute::post('/register',                 RegisterAction::class);
  ORoute::post('/travel',                   TravelAction::class,                 [GameFilter::class]);
  ORoute::post('/update-position',          UpdatePositionAction::class,         [GameFilter::class]);
});
