<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Routing\OModule;

#[OModule(
	actions: 'changeScenario, deleteGame, getGames, getPlayData, getScenarioConnections, getUnlockedWorlds, hitEnemy, login, newGame, register, travel, updatePosition',
	type: 'json',
	prefix: '/api'
)]
class apiModule {}
