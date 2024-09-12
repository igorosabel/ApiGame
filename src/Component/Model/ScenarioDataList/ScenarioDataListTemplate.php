<?php
use Osumi\OsumiFramework\App\Component\Model\ScenarioData\ScenarioDataComponent;

foreach ($values['list'] as $i => $ScenarioData) {
  $component = new ScenarioDataComponent([ 'ScenarioData' => $ScenarioData ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
