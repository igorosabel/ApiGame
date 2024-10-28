<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Admin\AdminLogin;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\Service\AdminService;

class AdminLoginComponent extends OComponent {
  private ?AdminService $as = null;

  public string $status = 'ok';
  public int    $id     = -1;
  public string $email  = '';
  public string $token  = '';

  public function __construct() {
    parent::__construct();
    $this->as = inject(AdminService::class);
  }

	/**
	 * Función para iniciar sesión en el admin
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$this->email = $req->getParamString('email');
		$pass        = $req->getParamString('pass');

		if (is_null($this->email) || is_null($pass)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$user = $this->as->adminLogin($this->email, $pass);
			if (!is_null($user)) {
				$this->id = $user->id;

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
