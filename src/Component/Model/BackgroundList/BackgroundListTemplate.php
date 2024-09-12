<?php
use Osumi\OsumiFramework\App\Component\Model\Background\BackgroundComponent;

foreach ($values['list'] as $i => $Background) {
  $component = new BackgroundComponent([ 'Background' => $Background ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
