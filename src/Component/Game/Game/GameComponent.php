<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Component\Game\Game;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\Model\Game;

class GameComponent extends OComponent {
  public ?Game $game = null;
}
