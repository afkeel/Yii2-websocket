<?php

namespace app\commands;

use yii\console\Controller;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use app\websocket\Socket;
use Yii;
use Ratchet\App;

class WebSocketServerController extends Controller {

    public function actionStart() {
        $app = new App('yiiprojects', 8080);
        $app->route('/socket', new Socket(), ['*']);
        $app->run();
     }
}
