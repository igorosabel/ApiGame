<?php

declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Middleware;

use Osumi\OsumiFramework\Core\OMiddleware;

OMiddleware::setGlobal([
	OMiddleware::PHASE_BEFORE => [],
	OMiddleware::PHASE_AFTER_RENDER => [],
	OMiddleware::PHASE_AFTER_RESPONSE => []
]);
