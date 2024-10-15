<?php
use Osumi\OsumiFramework\App\Component\Game\Game\GameComponent;

foreach ($list as $i => $game) {
	$game_component = new GameComponent([ 'game' => $game ]);
	echo strval($game_component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
