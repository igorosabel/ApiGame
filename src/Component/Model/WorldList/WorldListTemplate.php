<?php
use Osumi\OsumiFramework\App\Component\Model\World\WorldComponent;

foreach ($values['list'] as $i => $World) {
  $component = new WorldComponent([ 'World' => $World ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
