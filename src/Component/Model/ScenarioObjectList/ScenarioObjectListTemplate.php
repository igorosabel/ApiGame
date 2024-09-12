<?php
use Osumi\OsumiFramework\App\Component\Model\ScenarioObject\ScenarioObjectComponent;

foreach ($values['list'] as $i => $ScenarioObject) {
  $component = new ScenarioObjectComponent([ 'ScenarioObject' => $ScenarioObject ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
