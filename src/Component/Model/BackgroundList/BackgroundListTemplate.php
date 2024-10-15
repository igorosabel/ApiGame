<?php
use Osumi\OsumiFramework\App\Component\Model\Background\BackgroundComponent;

foreach ($list as $i => $background) {
  $component = new BackgroundComponent([ 'background' => $background ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
