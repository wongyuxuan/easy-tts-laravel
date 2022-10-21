<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Driver\Tencent;

use EasyTts\Driver\Tencent\Config\StreamConfig;
use EasyTts\Driver\Tencent\Config\TaskConfig;
use EasyTts\TtsClient;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Tts\V20190823\Models\DescribeTtsTaskStatusRequest;
use TencentCloud\Tts\V20190823\TtsClient as TencentTtsClient;

class Client extends TtsClient
{
    /**
     * @var Credential
     */
    private $credential;

    public function __construct($appKey, $accessKeyId, $accessKeySecret)
    {
        parent::__construct();
        $this->credential = new Credential($accessKeyId, $accessKeySecret);
    }

    /**
     * 文字转语音----流式处理
     */
    public function createTask(string $text)
    {
        $httpProfile = new HttpProfile();
        $httpProfile->setReqMethod("POST");
        $httpProfile->setReqTimeout(30);

        $clientProfile = new ClientProfile();
        $clientProfile->setSignMethod("TC3-HMAC-SHA256");  // 指定签名算法(默认为HmacSHA256)
        $clientProfile->setHttpProfile($httpProfile);

        $ttsConfig = (new TaskConfig($this->getRequestConfig()));
        $ttsConfig->setText($text);
        $client = new TencentTtsClient($this->credential, null, $clientProfile);
        return $client->CreateTtsTask($ttsConfig);
    }

    public function fetchTaskResult($taskId)
    {
        $httpProfile = new HttpProfile();
        $httpProfile->setReqMethod("POST");
        $httpProfile->setReqTimeout(30);

        $clientProfile = new ClientProfile();
        $clientProfile->setSignMethod("TC3-HMAC-SHA256");  // 指定签名算法(默认为HmacSHA256)
        $clientProfile->setHttpProfile($httpProfile);

        $client = new TencentTtsClient($this->credential, null, $clientProfile);

        $req = new DescribeTtsTaskStatusRequest();
        $req->setTaskId($taskId);

        return $client->DescribeTtsTaskStatus($req);
    }

    function textToSpeechStream(string $text)
    {
        $httpProfile = new HttpProfile();
        $httpProfile->setReqMethod("POST");
        $httpProfile->setReqTimeout(30);

        $clientProfile = new ClientProfile();
        $clientProfile->setSignMethod("TC3-HMAC-SHA256");  // 指定签名算法(默认为HmacSHA256)
        $clientProfile->setHttpProfile($httpProfile);

        $ttsConfig = (new StreamConfig($this->getRequestConfig()));
        $ttsConfig->setText($text);
        $client = new TencentTtsClient($this->credential, 'ap-shanghai', $clientProfile);
        return $client->TextToVoice($ttsConfig);
    }
}
