<?php declare(strict_types=1);

namespace OsumiFramework\App\Component;

use OsumiFramework\OFW\Core\OComponent;

class GameComponent extends OComponent {
	public array $depends = ['model/equipment', 'model/item'];
}
