<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Task;

use Osumi\OsumiFramework\Core\OTask;
use Osumi\OsumiFramework\Plugins\OWebsocket;

class StartServerTask extends OTask {
  public function __toString() {
		return "startServer: Tarea para arrancar el servidor de WebSockets";
	}

  public function run(array $options=[]): void {
    OWebsocket::setValidateMethod([$this, 'validateToken']);
    OWebsocket::loadActions();
    OWebsocket::start();
  }

  public function validateToken(string $token): ?array {
    if ($token === 'test-token') {
      return [
        'id' => 1,
        'name' => 'Admin'
      ];
    }

    return null;
  }
}
