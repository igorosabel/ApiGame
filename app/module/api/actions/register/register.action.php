<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\App\Model\User;
use OsumiFramework\App\Model\Game;

#[OModuleAction(
	url: '/register'
)]
class registerAction extends OAction {
	/**
	 * Función para registrar un nuevo usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = -1;
		$email  = $req->getParamString('email');
		$pass   = $req->getParamString('pass');
		$token  = '';

		if (is_null($email) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$user = new User();

			if ($user->find(['email' => $email])) {
				$status = 'in-use';
			}
			else {
				$user->set('email', $email);
				$user->set('pass',  password_hash($pass, PASSWORD_BCRYPT));
				$user->set('admin', false);
				$user->save();

				$id = $user->get('id');

				for ($i=0; $i<3; $i++) {
					$game = new Game();
					$game->set('id_user',     $user->get('id'));
					$game->set('name',        null);
					$game->set('id_scenario', null);
					$game->set('position_x',  null);
					$game->set('position_y',  null);
					$game->set('money',       $this->getConfig()->getExtra('start_money'));
					$game->set('health',      $this->getConfig()->getExtra('start_health'));
					$game->set('max_health',  $this->getConfig()->getExtra('start_health'));
					$game->set('attack',      $this->getConfig()->getExtra('start_attack'));
					$game->set('defense',     $this->getConfig()->getExtra('start_defense'));
					$game->set('speed',       $this->getConfig()->getExtra('start_speed'));
					$game->save();
				}

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('email', $email);
				$tk->addParam('admin', false);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
	}
}
