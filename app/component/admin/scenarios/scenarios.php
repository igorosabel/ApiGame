<?php
foreach ($values['list'] as $i => $sce) {
	echo OTools::getPartial($values['route'], [ 'sce' => $sce ]);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}