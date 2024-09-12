<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Filter;

use Osumi\OsumiFramework\Plugins\OToken;

class AdminFilter {
	/**
	 * Filtro de seguridad para administradores
	 *
	 * @param array $params Parameter array received on the call
	 *
	 * @param array $headers HTTP header array received on the call
	 *
	 * @return array Return filter status (ok / error) and information
	 */
	public static function handle(array $params, array $headers): array {
		global $core;
		$ret = ['status'=>'error', 'id'=>null];

		$tk = new OToken($core->config->getExtra('secret'));
		if ($tk->checkToken($headers['Authorization']) && $tk->getParam('admin')===true){
			$ret['status'] = 'ok';
			$ret['id'] = $tk->getParam('id');
		}

		return $ret;
	}
}
