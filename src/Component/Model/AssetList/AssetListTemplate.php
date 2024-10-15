<?php
use Osumi\OsumiFramework\App\Component\Model\Asset\AssetComponent;

foreach ($list as $i => $asset) {
  $component = new AssetComponent([ 'asset' => $asset ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
