<?php
use Osumi\OsumiFramework\App\Component\Game\Game\GameComponent;

foreach ($values['list'] as $i => $Game) {
	$game_component = new GameComponent([ 'Game' => $Game ]);
	echo strval($game_component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
