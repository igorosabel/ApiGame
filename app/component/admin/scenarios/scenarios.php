<?php
foreach ($values['list'] as $i => $sce) {
	echo OTools::getComponent('admin/scenario', [ 'sce' => $sce ]);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}