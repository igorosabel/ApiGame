<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\AdminLogin;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class AdminLoginAction extends OAction {
  public string $status = 'ok';
  public int    $id     = -1;
  public string $email  = '';
  public string $token  = '';

	/**
	 * Función para iniciar sesión en el admin
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$this->email = $req->getParamString('email');
		$pass        = $req->getParamString('pass');

		if (is_null($this->email) || is_null($pass)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$user = new User();
			if ($user->login($this->email, $pass) && $user->get('admin')) {
				$this->id = $user->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $this->id);
				$tk->addParam('email', $this->email);
				$tk->addParam('admin', true);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
