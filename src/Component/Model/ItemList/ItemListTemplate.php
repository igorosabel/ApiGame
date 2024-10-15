<?php
use Osumi\OsumiFramework\App\Component\Model\Item\ItemComponent;

foreach ($list as $i => $item) {
  $component = new ItemComponent([ 'item' => $item ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
