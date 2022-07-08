<?php
use OsumiFramework\App\Component\Model\ItemComponent;

foreach ($values['list'] as $i => $item) {
	$item_component = new ItemComponent([ 'item' => $item ]);
	echo $item_component;
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
