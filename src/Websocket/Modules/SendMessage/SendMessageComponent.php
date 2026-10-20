<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Websocket\Modules;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;

class SendMessageComponent extends OComponent {
  public string $status = 'ok';
  public string $message = '';

  public function run(ORequest $req): void {
    $this->message = 'pong';
  }
}
