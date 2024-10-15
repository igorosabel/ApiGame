<?php
use Osumi\OsumiFramework\App\Component\Model\ScenarioData\ScenarioDataComponent;

foreach ($list as $i => $scenariodata) {
  $component = new ScenarioDataComponent([ 'scenariodata' => $scenariodata ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
