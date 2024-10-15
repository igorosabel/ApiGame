<?php
use Osumi\OsumiFramework\App\Component\Model\Character\CharacterComponent;

foreach ($list as $i => $character) {
  $component = new CharacterComponent([ 'character' => $character ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
