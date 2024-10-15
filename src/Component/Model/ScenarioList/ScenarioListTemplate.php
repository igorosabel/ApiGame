<?php
use Osumi\OsumiFramework\App\Component\Model\Scenario\ScenarioComponent;

foreach ($list as $i => $scenario) {
  $component = new ScenarioComponent([ 'scenario' => $scenario ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
