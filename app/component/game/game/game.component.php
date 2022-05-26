<?php declare(strict_types=1);

namespace OsumiFramework\App\Component;

use OsumiFramework\OFW\Core\OComponent;

class GameComponent extends OComponent {
  private string $depends = 'model/equipment, model/item';
}
