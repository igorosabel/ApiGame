<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Login;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class LoginAction extends OAction {
  public string $status = 'ok';
  public int    $id     = -1;
  public string $email  = '';
  public string $token  = '';

	/**
	 * Función para iniciar sesión en el juego
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->email  = $req->getParamString('email');
		$pass         = $req->getParamString('pass');

		if (is_null($this->email) || is_null($pass)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$user = new User();
			if ($user->login($this->email, $pass)) {
				$this->id = $user->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $this->id);
				$tk->addParam('email', $this->email);
				$tk->addParam('admin', $user->get('admin'));
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
