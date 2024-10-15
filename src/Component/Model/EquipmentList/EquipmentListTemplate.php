<?php
use Osumi\OsumiFramework\App\Component\Model\Equipment\EquipmentComponent;

foreach ($list as $i => $equipment) {
  $component = new EquipmentComponent([ 'equipment' => $equipment ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
