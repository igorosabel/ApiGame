<?php
use Osumi\OsumiFramework\App\Component\Model\World\WorldComponent;

foreach ($list as $i => $world) {
  $component = new WorldComponent([ 'world' => $world ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
