<?php
use Osumi\OsumiFramework\App\Component\Model\Tag\TagComponent;

foreach ($list as $i => $tag) {
  $component = new TagComponent([ 'tag' => $tag ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
