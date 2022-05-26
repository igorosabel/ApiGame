<?php
use OsumiFramework\App\Component\GameComponent;

foreach ($values['list'] as $i => $game) {
	$game_component = new GameComponent([ 'game' => $game ]);
	echo $game_component;
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
