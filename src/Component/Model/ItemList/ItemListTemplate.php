<?php
use Osumi\OsumiFramework\App\Component\Model\Item\ItemComponent;

foreach ($values['list'] as $i => $Item) {
  $component = new ItemComponent([ 'Item' => $Item ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
