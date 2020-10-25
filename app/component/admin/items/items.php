<?php
foreach ($values['list'] as $i => $item) {
	echo OTools::getComponent('admin/item', [ 'item' => $item ]);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}