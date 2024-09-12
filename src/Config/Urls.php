<?php declare(strict_types=1);

use Osumi\OsumiFramework\Routing\OUrl;
use Osumi\OsumiFramework\App\Module\Admin\AdminLogin\AdminLoginAction;
use Osumi\OsumiFramework\App\Module\Admin\AssetList\AssetListAction;
use Osumi\OsumiFramework\App\Module\Admin\BackgroundCategoryList\BackgroundCategoryListAction;
use Osumi\OsumiFramework\App\Module\Admin\BackgroundList\BackgroundListAction;
use Osumi\OsumiFramework\App\Module\Admin\CharacterList\CharacterListAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteAsset\DeleteAssetAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteBackground\DeleteBackgroundAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteBackgroundCategory\DeleteBackgroundCategoryAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteCharacter\DeleteCharacterAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteConnection\DeleteConnectionAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteItem\DeleteItemAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteScenario\DeleteScenarioAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteScenarioObject\DeleteScenarioObjectAction;
use Osumi\OsumiFramework\App\Module\Admin\DeleteWorld\DeleteWorldAction;
use Osumi\OsumiFramework\App\Module\Admin\GenerateMap\GenerateMapAction;
use Osumi\OsumiFramework\App\Module\Admin\GetScenario\GetScenarioAction;
use Osumi\OsumiFramework\App\Module\Admin\ItemList\ItemListAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveAsset\SaveAssetAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveBackground\SaveBackgroundAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveBackgroundCategory\SaveBackgroundCategoryAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveCharacter\SaveCharacterAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveConnection\SaveConnectionAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveItem\SaveItemAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveScenario\SaveScenarioAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveScenarioData\SaveScenarioDataAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveScenarioObject\SaveScenarioObjectAction;
use Osumi\OsumiFramework\App\Module\Admin\SaveWorld\SaveWorldAction;
use Osumi\OsumiFramework\App\Module\Admin\ScenarioList\ScenarioListAction;
use Osumi\OsumiFramework\App\Module\Admin\ScenarioObjectList\ScenarioObjectListAction;
use Osumi\OsumiFramework\App\Module\Admin\SelectWorldStart\SelectWorldStartAction;
use Osumi\OsumiFramework\App\Module\Admin\TagList\TagListAction;
use Osumi\OsumiFramework\App\Module\Admin\WorldList\WorldListAction;
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
use Osumi\OsumiFramework\App\Module\Home\Index\IndexAction;

use Osumi\OsumiFramework\App\Filter\AdminFilter;
use Osumi\OsumiFramework\App\Filter\GameFilter;
use Osumi\OsumiFramework\App\Service\AdminService;
use Osumi\OsumiFramework\App\Service\WebService;

$admin_urls = [
  [
    'url' => '/login',
    'action' => AdminLoginAction::class,
    'type' => 'json'
  ],
  [
    'url' => '/asset-list',
    'action' => AssetListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/background-category-list',
    'action' => BackgroundCategoryListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/background-list',
    'action' => BackgroundListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/character-list',
    'action' => CharacterListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-asset',
    'action' => DeleteAssetAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-background',
    'action' => DeleteBackgroundAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-background-category',
    'action' => DeleteBackgroundCategoryAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-character',
    'action' => DeleteCharacterAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-connection',
    'action' => DeleteConnectionAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-item',
    'action' => DeleteItemAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-scenario',
    'action' => DeleteScenarioAction::class,
    'filters' => [AdminFilter::class],
    'services' => [
      AdminService::class,
      WebService::class,
    ],
    'type' => 'json'
  ],
  [
    'url' => '/delete-scenario-object',
    'action' => DeleteScenarioObjectAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-world',
    'action' => DeleteWorldAction::class,
    'filters' => [AdminFilter::class],
    'services' => [
      AdminService::class,
      WebService::class,
    ],
    'type' => 'json'
  ],
  [
    'url' => '/generate-map',
    'action' => GenerateMapAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-scenario',
    'action' => GetScenarioAction::class,
    'filters' => [AdminFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/item-list',
    'action' => ItemListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-asset',
    'action' => SaveAssetAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-background',
    'action' => SaveBackgroundAction::class,
    'filters' => [AdminFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-background-category',
    'action' => SaveBackgroundCategoryAction::class,
    'filters' => [AdminFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-character',
    'action' => SaveCharacterAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-connection',
    'action' => SaveConnectionAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-item',
    'action' => SaveItemAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-scenario',
    'action' => SaveScenarioAction::class,
    'filters' => [AdminFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-scenario-data',
    'action' => SaveScenarioDataAction::class,
    'filters' => [AdminFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-scenario-object',
    'action' => SaveScenarioObjectAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/save-world',
    'action' => SaveWorldAction::class,
    'filters' => [AdminFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/scenario-list',
    'action' => ScenarioListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/scenario-object-list',
    'action' => ScenarioObjectListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/select-world-start',
    'action' => SelectWorldStartAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/tag-list',
    'action' => TagListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
  [
    'url' => '/world-list',
    'action' => WorldListAction::class,
    'filters' => [AdminFilter::class],
    'services' => [AdminService::class],
    'type' => 'json'
  ],
];

$api_urls = [
  [
    'url' => '/change-scenario',
    'action' => ChangeScenarioAction::class,
    'filters' => [GameFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-game',
    'action' => DeleteGameAction::class,
    'filters' => [GameFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-games',
    'action' => GetGamesAction::class,
    'filters' => [GameFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-play-data',
    'action' => GetPlayDataAction::class,
    'filters' => [GameFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-scenario-connections',
    'action' => GetScenarioConnectionsAction::class,
    'filters' => [GameFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-unlocked-worlds',
    'action' => GetUnlockedWorldsAction::class,
    'filters' => [GameFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/hit-enemy',
    'action' => HitEnemyAction::class,
    'filters' => [GameFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/login',
    'action' => LoginAction::class,
    'type' => 'json'
  ],
  [
    'url' => '/new-game',
    'action' => NewGameAction::class,
    'filters' => [GameFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/register',
    'action' => RegisterAction::class,
    'type' => 'json'
  ],
  [
    'url' => '/travel',
    'action' => TravelAction::class,
    'filters' => [GameFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/update-position',
    'action' => UpdatePositionAction::class,
    'filters' => [GameFilter::class],
    'type' => 'json'
  ],
];

$home_urls = [
  [
    'url' => '/',
    'action' => IndexAction::class
  ],
];

$urls = [];
OUrl::addUrls($urls, $admin_urls, '/admin');
OUrl::addUrls($urls, $api_urls, '/api');
OUrl::addUrls($urls, $home_urls);

return $urls;
