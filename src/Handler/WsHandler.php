<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Handler;

use WebSocket\Client;
use WebSocket\Exception;
use GuzzleHttp\Psr7\Response;

/**
 * WebSocket处理类
 *
 * @author guizheng@iflytek.com
 */
class WsHandler
{
    private $client;

    /**
     * @var string 发送的字符串
     */
    private $input;

    public function __construct($uri, $input, $timeout = 300)
    {
        $this->client = new Client($uri);
        $this->client->setTimeout($timeout);
        $this->input = $input;
    }

    /**
     * 发送并等待获取返回
     *
     * 这是一个同步阻塞的过程，调用将持续到结果返回或者出现超时
     */
    public function sendAndReceive()
    {
        $result = '';
        try {
            $this->client->send($this->input);
            while (true) {
                $message = $this->jsonDecode($this->client->receive());
                if ($message->code !== 0) {
                    throw new \Exception(json_encode($message));
                }
                switch ($message->data->status) {
                    case 1:
                        $result .= base64_decode($message->data->audio);
                        break;
                    case 2:
                        $result .= base64_decode($message->data->audio);
                        break 2;
                }
            }
            return new Response(200, [], $result);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function send($message = null)
    {
        try {
            if (empty($message)) {
                if (!empty($this->input)) {
                    $message = $this->input;
                } else {
                    throw new Exception();
                }
            }
            $this->client->send($message);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function receive()
    {
        return $this->client->receive();
    }

    /**
     * @param   string  $json       待解码的字符串
     * @param   bool    $assoc      是否返回数组
     * @param   int     $depth      递归深度
     * @param   int     $options    json_decode的配置
     * @return  mixed
     * @throws  \InvalidArgumentException
     */
    private static function jsonDecode($json, $assoc = false, $options = 0, $depth = 512)
    {
        $data = json_decode($json, $assoc, $depth, $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_decode error: ' . json_last_error_msg()
            );
        }

        return $data;
    }
}
