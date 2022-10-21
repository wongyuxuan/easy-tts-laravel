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

use EasyTts\Handler\HttpHandler;

class Auth
{
    private $accessToken;

    const GRANT_TYPE = 'client_credentials';

    const TOKEN_URL = 'https://openapi.baidu.com/oauth/2.0/token';

    public function __construct($secretId, $secretKey)
    {
        $this->setAccessToken($secretId, $secretKey);
    }

    private function setAccessToken($secretId, $secretKey)
    {
        $options = [
            'grant_type' => self::GRANT_TYPE,
            'client_id' => $secretId,
            'client_secret' => $secretKey
        ];

        $httpHandler = new HttpHandler();
        $res = $httpHandler->parseJSON($httpHandler->get(self::TOKEN_URL, $options));
        $this->accessToken = $res['access_token'];
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
