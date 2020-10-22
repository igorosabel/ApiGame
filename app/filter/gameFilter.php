<?php declare(strict_types=1);
/**
 * Filtro de seguridad para administradores
 *
 * @param array $params Parameter array received on the call
 *
 * @param array $headers HTTP header array received on the call
 *
 * @return array Return filter status (ok / error) and information
 */
function gameFilter(array $params, array $headers): array {
	global $core;
	$ret = ['status'=>'error', 'id'=>null];

	$tk = new OToken($core->config->getExtra('secret'));
	if ($tk->checkToken($headers['Authorization'])){
		$ret['status'] = 'ok';
		$ret['id'] = $tk->getParam('id');
	}

	return $ret;
}