<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Middleware\GameMiddleware;
use Osumi\OsumiFramework\App\Module\Api\ChangeScenario\ChangeScenarioComponent;
use Osumi\OsumiFramework\App\Module\Api\DeleteGame\DeleteGameComponent;
use Osumi\OsumiFramework\App\Module\Api\GetGames\GetGamesComponent;
use Osumi\OsumiFramework\App\Module\Api\GetPlayData\GetPlayDataComponent;
use Osumi\OsumiFramework\App\Module\Api\GetScenarioConnections\GetScenarioConnectionsComponent;
use Osumi\OsumiFramework\App\Module\Api\GetUnlockedWorlds\GetUnlockedWorldsComponent;
use Osumi\OsumiFramework\App\Module\Api\HitEnemy\HitEnemyComponent;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginComponent;
use Osumi\OsumiFramework\App\Module\Api\NewGame\NewGameComponent;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterComponent;
use Osumi\OsumiFramework\App\Module\Api\Travel\TravelComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdatePosition\UpdatePositionComponent;

ORoute::prefix('/api', function() {
  ORoute::post('/change-scenario',          ChangeScenarioComponent::class,         ['before' => [GameMiddleware::class]]);
  ORoute::post('/delete-game',              DeleteGameComponent::class,             ['before' => [GameMiddleware::class]]);
  ORoute::post('/get-games',                GetGamesComponent::class,               ['before' => [GameMiddleware::class]]);
  ORoute::post('/get-play-data',            GetPlayDataComponent::class,            ['before' => [GameMiddleware::class]]);
  ORoute::post('/get-scenario-connections', GetScenarioConnectionsComponent::class, ['before' => [GameMiddleware::class]]);
  ORoute::post('/get-unlocked-worlds',      GetUnlockedWorldsComponent::class,      ['before' => [GameMiddleware::class]]);
  ORoute::post('/hit-enemy',                HitEnemyComponent::class,               ['before' => [GameMiddleware::class]]);
  ORoute::post('/login',                    LoginComponent::class);
  ORoute::post('/new-game',                 NewGameComponent::class,                ['before' => [GameMiddleware::class]]);
  ORoute::post('/register',                 RegisterComponent::class);
  ORoute::post('/travel',                   TravelComponent::class,                 ['before' => [GameMiddleware::class]]);
  ORoute::post('/update-position',          UpdatePositionComponent::class,         ['before' => [GameMiddleware::class]]);
});
