<?php
use Osumi\OsumiFramework\App\Component\Model\Scenario\ScenarioComponent;

foreach ($values['list'] as $i => $Scenario) {
  $component = new ScenarioComponent([ 'Scenario' => $Scenario ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
