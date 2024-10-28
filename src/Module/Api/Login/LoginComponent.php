<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Login;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class LoginComponent extends OComponent {
  private ?WebService $ws = null;

  public string $status = 'ok';
  public int    $id     = -1;
  public string $email  = '';
  public string $token  = '';

  public function __construct() {
    parent::__construct();
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para iniciar sesión en el juego
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$this->email  = $req->getParamString('email');
		$pass         = $req->getParamString('pass');

		if (is_null($this->email) || is_null($pass)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$user = $this->ws->userLogin($this->email, $pass);
			if (!is_null($user)) {
				$this->id = $user->id;

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $this->id);
				$tk->addParam('email', $this->email);
				$tk->addParam('admin', $user->admin);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
