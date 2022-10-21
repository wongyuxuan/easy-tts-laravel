<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Driver\Xunfei;

use EasyTts\Driver\Xunfei\Config\TtsConfig;
use EasyTts\Handler\WsHandler;
use EasyTts\TtsClient;

class Client extends TtsClient
{
    private $auth;

    public $appKey;

    const STREAM_REQUEST_URL = "wss://tts-api.xfyun.cn/v2/tts";

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
        $ttsConfigArray = (new TtsConfig($this->getRequestConfig()))->toArray();

        $uri = self::STREAM_REQUEST_URL . '?' . http_build_query([
                'host' => Auth::HOST,
                'date' => $this->auth->getDate(),
                'authorization' => $this->auth->getAccessToken()
            ]);
        $input = [
            'common' => [
                'app_id' => $this->appKey
            ],
            'business' => $ttsConfigArray,
            'data' => [
                'text' => base64_encode($text),
                'status' => 2
            ]
        ];

        return (new WsHandler($uri, json_encode($input)))->sendAndReceive()->getBody()->getContents();
    }
}
