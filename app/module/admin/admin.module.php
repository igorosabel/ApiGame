<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Routing\OModule;

#[OModule(
	actions: ['adminLogin', 'assetList', 'backgroundCategoryList', 'backgroundList', 'characterList', 'deleteAsset', 'deleteBackground', 'deleteBackgroundCategory', 'deleteCharacter', 'deleteConnection', 'deleteItem', 'deleteScenario', 'deleteScenarioObject', 'deleteWorld', 'generateMap', 'getScenario', 'itemList', 'saveAsset', 'saveBackground', 'saveBackgroundCategory', 'saveCharacter', 'saveConnection', 'saveItem', 'saveScenario', 'saveScenarioData', 'saveScenarioObject', 'saveWorld', 'scenarioList', 'scenarioObjectList', 'selectWorldStart', 'tagList', 'worldList'],
	type: 'json',
	prefix: '/admin'
)]
class adminModule {}
