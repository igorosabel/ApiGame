<?php
use Osumi\OsumiFramework\App\Component\Model\ScenarioObject\ScenarioObjectComponent;

foreach ($list as $i => $scenarioobject) {
  $component = new ScenarioObjectComponent([ 'scenarioobject' => $scenarioobject ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
