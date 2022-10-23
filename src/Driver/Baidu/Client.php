<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Driver\Baidu;

use EasyTts\Driver\Baidu\Config\StreamConfig;
use EasyTts\Driver\Baidu\Config\TaskConfig;
use EasyTts\Handler\HttpHandler;
use EasyTts\TtsClient;

class Client extends TtsClient
{
    private $auth;

    public $appKey;

    const STREAM_REQUEST_URL = "https://tsn.baidu.com/text2audio";

    const TASK_URL = "https://aip.baidubce.com/rpc/2.0/tts/v1/create";

    const TASK_REQUEST_URL = "https://aip.baidubce.com/rpc/2.0/tts/v1/query";

    public function __construct($appKey, $accessKeyId, $accessKeySecret)
    {
        parent::__construct();
        $this->auth = new Auth($accessKeyId, $accessKeySecret);
        $this->appKey = $appKey;
    }

    /**
     * 文字转语音----流式处理
     * @param string $text
     * @return mixed|string
     * @throws \HttpException
     */
    public function textToSpeechStream(string $text)
    {
        $body = (new StreamConfig($this->getRequestConfig()))->toArray();
        $body += [
            'tok' => $this->auth->getAccessToken(),
            'tex' => $text
        ];

        $httpHandler = new HttpHandler();
        return $httpHandler->post(self::STREAM_REQUEST_URL, $body)->getBody()->getContents();
    }

    /**
     * 文字转语音----异步任务处理
     * https://ai.baidu.com/ai-doc/SPEECH/1ku59x8ey
     * @param string $text
     * @return string
     */
    public function createTask(string $text)
    {
        $body = (new TaskConfig($this->getRequestConfig()))->toArray();
        $body += [
            'text' => $text
        ];
        $query = [
            'access_token' => $this->auth->getAccessToken()
        ];

        $httpHandler = new HttpHandler();
        $res = $httpHandler->json(self::TASK_URL, $body, JSON_UNESCAPED_UNICODE, $query);

        return $httpHandler->parseJSON($res);
    }

    public function fetchTaskResult($taskId)
    {
        $body = [
            'task_ids' => [$taskId]
        ];
        $query = [
            'access_token' => $this->auth->getAccessToken()
        ];

        $httpHandler = new HttpHandler();
        $res = $httpHandler->json(self::TASK_REQUEST_URL, $body, JSON_UNESCAPED_UNICODE, $query);

        return $httpHandler->parseJSON($res);
    }
}
