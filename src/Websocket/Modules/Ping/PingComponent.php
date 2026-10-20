<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Websocket\Modules\Ping;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;

class PingComponent extends OComponent {
  public string $status = 'ok';
  public string $message = '';

  public function run(ORequest $req): void {
    $this->message = 'pong';
  }
}
