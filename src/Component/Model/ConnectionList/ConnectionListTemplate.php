<?php
use Osumi\OsumiFramework\App\Component\Model\Connection\ConnectionComponent;

foreach ($list as $i => $connection) {
  $component = new ConnectionComponent([ 'connection' => $connection ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
