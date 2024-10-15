<?php
use Osumi\OsumiFramework\App\Component\Model\BackgroundCategory\BackgroundCategoryComponent;

foreach ($list as $i => $backgroundcategory) {
  $component = new BackgroundCategoryComponent([ 'backgroundcategory' => $backgroundcategory ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
