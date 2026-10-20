<?php

declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Middleware;

use Osumi\OsumiFramework\Core\OMiddleware;
use Osumi\OsumiFramework\Plugins\OToken;

final class GameMiddleware {
	/**
	 * Filtro de seguridad para jugadores
	 *
	 * @param string $phase Current middleware phase.
	 * @param array<string, mixed> $data Current middleware pipeline data.
	 *
	 * @return array<string, mixed> Middleware result.
	 */
	public static function handle(
		string $phase,
		array $data
	): array {
		if ($phase !== OMiddleware::PHASE_BEFORE) {
			return [];
		}

		global $core;

		$headers = $data['headers'] ?? [];

		if (!is_array($headers)) {
			return [
				'stop' => true,
				'status_code' => 403,
				'message' => ''
			];
		}

		$authorization = $headers['Authorization']
			?? null;

		if (!is_string($authorization)) {
			return [
				'stop' => true,
				'status_code' => 403,
				'message' => ''
			];
		}

		$token = new OToken(
			$core->config->getExtra('secret')
		);

		if (!$token->checkToken($authorization)) {
			return [
				'stop' => true,
				'status_code' => 403,
				'message' => ''
			];
		}

		return [
			'context' => [
				'status' => 'ok',
				'id' => (int) $token->getParam('id')
			]
		];
	}
}
