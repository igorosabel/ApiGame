<?php
use Osumi\OsumiFramework\App\Component\Model\Equipment\EquipmentComponent;

foreach ($values['list'] as $i => $Equipment) {
  $component = new EquipmentComponent([ 'Equipment' => $Equipment ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
