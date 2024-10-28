<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Register;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\Model\Game;

class RegisterComponent extends OComponent {
  public string $status = 'ok';
  public int    $id     = -1;
  public string $name   = '';
  public string $token  = '';

	/**
	 * Función para registrar un nuevo usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$email  = $req->getParamString('email');
		$pass   = $req->getParamString('pass');

		if (is_null($email) || is_null($pass)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$user = User::findOne(['email' => $email]);

			if (!is_null($user)) {
				$this->status = 'in-use';
			}
			else {
        $user = User::create();
				$user->email = $email;
				$user->pass  = password_hash($pass, PASSWORD_BCRYPT);
				$user->admin = false;
				$user->save();

				$this->id = $user->id;

				for ($i = 0; $i < 3; $i++) {
					$game = Game::create();
					$game->id_user     = $user->id;
					$game->name        = null;
					$game->id_scenario = null;
					$game->position_x  = null;
					$game->position_y  = null;
					$game->money       = $this->getConfig()->getExtra('start_money');
					$game->health      = $this->getConfig()->getExtra('start_health');
					$game->max_health  = $this->getConfig()->getExtra('start_health');
					$game->attack      = $this->getConfig()->getExtra('start_attack');
					$game->defense     = $this->getConfig()->getExtra('start_defense');
					$game->speed       = $this->getConfig()->getExtra('start_speed');
					$game->save();
				}

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $this->id);
				$tk->addParam('email', $this->email);
				$tk->addParam('admin', false);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
		}
	}
}
