<?php declare(strict_types=1);
/**
 * Filtro de seguridad para usuarios
 *
 * @param array $params Parameter array received on the call
 *
 * @param array $headers HTTP header array received on the call
 *
 * @return array Return filter status (ok / error) and information
 */
function sessionFilter(array $params, array $headers): array {
	global $core;
	$ret = ['status'=>'error', 'id'=>null];

	if ($core->session->getParam('logged')){
      $ret['status'] = 'ok';
      $ret['id']     = $core->session->getParam('id');
    }

	return $ret;
}