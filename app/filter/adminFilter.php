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
function adminFilter(array $params, array $headers): array {
	global $core;
	$ret = ['status'=>'error', 'id'=>null];

	if ($core->session->getParam('admin')){
      $ret['status'] = 'ok';
    }

	return $ret;
}