<?php
use OsumiFramework\App\Component\Model\ScenarioComponent;

foreach ($values['list'] as $i => $sce) {
	$scenario_component = new ScenarioComponent([ 'sce' => $sce ]);
	echo $scenario_component;
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
