<?php

namespace app\websocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use yii\helpers\Json;
use app\models\Session;
use SplObjectStorage;
use Exception;
use Yii;

class Socket implements MessageComponentInterface {

    protected $client;
    protected $allowedTokens = [
        'Dqq4LsGAIeeoNSe?=uBboE37IOefWwt=G9ou?hsgj?GZMThj56T2rpH'
    ];

    public function onOpen(ConnectionInterface $conn) {
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $queryParams);

        if (!isset($queryParams['token']) || !in_array($queryParams['token'], $this->allowedTokens)) {
            $conn->close();
            return;
        }

        $this->client = $conn;

        $conn->session = [
            'created_at' => date('Y-m-d H:i:s'),
            'token' => $queryParams['token'],
            'user_id' => $queryParams['user_id'] ?? null,
            'user_agent' => $conn->httpRequest->getHeader('User-Agent')[0] ?? null
        ];

        Yii::info("New connection: {$conn->resourceId}", 'websocket');
    }

    public function onMessage($from, $msg) {
        $this->cient->send("Server response: $msg");
    }

    public function onClose(ConnectionInterface $conn) {
        $model = new Session();
        $model->token = $conn->session['token'];
        $model->user_id = $conn->session['user_id'];
        $model->user_agent = $conn->session['user_agent'];
        $model->created_at = $conn->session['created_at'];
        $model->closed_at = date('Y-m-d H:i:s');
        $model->save();
        Yii::info("Connection {$conn->resourceId} has disconnected", 'websocket');
    }

    public function onError(ConnectionInterface $conn, Exception $e) {
        Yii::error($e->getMessage(), 'websocket');
        $conn->close();
    }
}
