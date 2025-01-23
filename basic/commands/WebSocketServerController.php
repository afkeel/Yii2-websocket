<?php

namespace app\commands;

use yii\console\Controller;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use app\websocket\Socket;
use Yii;

class WebSocketServerController extends Controller {
    public function actionStart($port = 8080) {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Socket()
                )
            ),
            $port
        );
        Yii::info("WebSocket server started on port $port");
        $server->run();
    }
}
