<?php
use Osumi\OsumiFramework\App\Component\Model\Character\CharacterComponent;

foreach ($values['list'] as $i => $Character) {
  $component = new CharacterComponent([ 'Character' => $Character ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
