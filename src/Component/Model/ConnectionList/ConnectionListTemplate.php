<?php
use Osumi\OsumiFramework\App\Component\Model\Connection\ConnectionComponent;

foreach ($values['list'] as $i => $Connection) {
  $component = new ConnectionComponent([ 'Connection' => $Connection ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
