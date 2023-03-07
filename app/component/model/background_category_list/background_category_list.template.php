<?php
use OsumiFramework\App\Component\Model\BackgroundCategoryComponent;

foreach ($values['list'] as $i => $backgroundcategory) {
  $component = new BackgroundCategoryComponent([ 'background_category' => $backgroundcategory ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
