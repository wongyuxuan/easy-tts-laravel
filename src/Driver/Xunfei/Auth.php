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

class Auth
{
    private $accessToken;

    private $date;

    const HOST = 'tts-api.xfyun.cn';

    const REQUEST_LINE = 'GET /v2/tts HTTP/1.1';

    public function __construct($secretId, $secretKey)
    {
        $this->setDate();
        $this->setAccessToken($secretId, $secretKey);
    }

    public function setDate()
    {
        $this->date = gmstrftime("%a, %d %b %Y %T %Z", time());
    }

    public function getDate()
    {
        return $this->date;
    }

    private function setAccessToken($secretId, $secretKey)
    {
        $host = self::HOST;
        $request_line = self::REQUEST_LINE;
        $date = $this->getDate();

        $signature_origin = "host: $host\ndate: $date\n$request_line";
        $signature_sha = hash_hmac('sha256', $signature_origin, $secretKey, true);
        $signature = base64_encode($signature_sha);

        $this->accessToken = base64_encode("api_key=\"$secretId\",algorithm=\"hmac-sha256\",headers=\"host date request-line\",signature=\"$signature\"");
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
