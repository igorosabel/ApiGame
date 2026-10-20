<?php declare(strict_types=1);

use Osumi\OsumiFramework\Plugins\OWebsocketAction;
use Osumi\OsumiFramework\App\Websocket\Modules\Ping\PingComponent;
use Osumi\OsumiFramework\App\Websocket\Modules\Login\LoginComponent;
use Osumi\OsumiFramework\App\Websocket\Modules\SendMessage\SendMessageComponent;

OWebsocketAction::register('ping', PingComponent::class);
OWebsocketAction::register('login', LoginComponent::class);
OWebsocketAction::register('send-message', SendMessageComponent::class, true);
