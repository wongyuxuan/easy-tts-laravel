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

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Auth
{
    private $accessToken;

    public function __construct($accessKeyId, $accessKeySecret)
    {
        $this->setAccessToken($accessKeyId, $accessKeySecret);
    }

    public function setAccessToken($accessKeyId, $accessKeySecret)
    {
        try {
            AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                ->regionId("cn-shanghai")
                ->asDefaultClient();
            $response = AlibabaCloud::nlsCloudMeta()
                ->v20180518()
                ->createToken()
                ->request();
            $this->accessToken = $response['Token']['Id'];
        } catch (ClientException|ServerException $exception) {
            throw $exception->getErrorMessage();
        }
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
