<?php
use Osumi\OsumiFramework\App\Component\Model\Asset\AssetComponent;

foreach ($values['list'] as $i => $Asset) {
  $component = new AssetComponent([ 'Asset' => $Asset ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
