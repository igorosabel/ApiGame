<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Component\Model\Connection;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\Model\Connection;

class ConnectionComponent extends OComponent {
  public ?Connection $connection = null;
}
