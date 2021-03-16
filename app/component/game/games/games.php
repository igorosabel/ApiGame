<?php

use OsumiFramework\OFW\Tools\OTools;

foreach ($values['list'] as $i => $game) {
	echo OTools::getComponent('game/game', [ 'game' => $game ]);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}