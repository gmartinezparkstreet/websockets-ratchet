<?php
use App\Providers\WebSocketServerService;

require dirname(__FILE__) . '/bootstrap/app.php';

// Add websocket server service with same configuration as cockpit
$port = 8090;

$app = new Ratchet\App('127.0.0.1', $port);

$app->route('/echo', new Ratchet\Server\EchoServer, ['*']);
$app->route('/chat', new WebSocketServerService, ['*']);

echo "Server running on port $port\n";

$app->run();

