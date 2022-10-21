<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Driver\Aliyun;

use EasyTts\Driver\Aliyun\Config\TtsConfig;
use EasyTts\Handler\HttpHandler;
use EasyTts\TtsClient;
use HttpException;

class Client extends TtsClient
{
    private $auth;

    public $appKey;

    const TASK_URL = "https://nls-gateway.cn-shanghai.aliyuncs.com/rest/v1/tts/async";

    const STREAM_REQUEST_URL = "https://nls-gateway-cn-shanghai.aliyuncs.com/stream/v1/tts";

    public function __construct($appKey, $accessKeyId, $accessKeySecret)
    {
        parent::__construct();
        $this->auth = new Auth($accessKeyId, $accessKeySecret);
        $this->appKey = $appKey;
    }

    public function textToSpeechStream(string $text)
    {
        $body = (new TtsConfig($this->getRequestConfig()))->toArray();
        $body += [
            'appkey' => $this->appKey,
            'token' => $this->auth->getAccessToken(),
            'text' => $text
        ];

        $httpHandler = new HttpHandler();
        return $httpHandler->json(self::STREAM_REQUEST_URL, $body)->getBody()->getContents();
    }

    /**
     * @throws HttpException
     */
    public function createTask($text)
    {
        $config = (new TtsConfig($this->getRequestConfig()))->toArray();
        $config += [
            'text' => $text
        ];

        $body = [
            'payload' => [
                'tts_request' => $config,
            ],
            'header' => [
                'appkey' => $this->appKey,
                'token' => $this->auth->getAccessToken()
            ]
        ];

        $httpHandler = new HttpHandler();
        $res = $httpHandler->json(self::TASK_URL, $body);

        return $httpHandler->parseJSON($res);
    }

    /**
     * 查询任务结果
     * @param $task_id
     * @param $request_id
     * @return false|mixed
     */
    public function fetchTaskResult($task_id, $request_id)
    {
        $options = [
            'appkey' => $this->appKey,
            'task_id' => $task_id,
            'token' => $this->auth->getAccessToken(),
            'request_id' => $request_id
        ];
        $httpHandler = new HttpHandler();
        $res = $httpHandler->get(self::TASK_URL, $options);
        return $httpHandler->parseJSON($res->getBody()->getContents());
    }
}
