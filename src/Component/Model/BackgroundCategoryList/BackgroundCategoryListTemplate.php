<?php
use Osumi\OsumiFramework\App\Component\Model\BackgroundCategory\BackgroundCategoryComponent;

foreach ($values['list'] as $i => $BackgroundCategory) {
  $component = new BackgroundCategoryComponent([ 'BackgroundCategory' => $BackgroundCategory ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
