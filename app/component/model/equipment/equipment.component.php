<?php declare(strict_types=1);

namespace OsumiFramework\App\Component;

use OsumiFramework\OFW\Core\OComponent;

class EquipmentComponent extends OComponent {
	public array $depends = ['model/item'];
}
