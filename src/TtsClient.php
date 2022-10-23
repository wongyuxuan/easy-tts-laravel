<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts;

abstract class TtsClient
{
    /**
     * 请求参数
     * @var array
     */
    private $requestConfig;

    public function __construct()
    {
        $this->setRequestConfig();
    }

    /**
     * 设置请求参数
     * @param array $config
     * @return $this
     */
    public function setRequestConfig(array $config = []): TtsClient
    {
        $this->requestConfig = $config;
        return $this;
    }

    /**
     * 获取请求参数
     * @return array
     */
    public function getRequestConfig(): array
    {
        return $this->requestConfig;
    }

    /**
     * 文字转语音----流式处理
     * @param string $text
     * @return mixed
     */
    abstract function textToSpeechStream(string $text);

    /**
     * 创建异步任务
     */
    abstract function createTask(string $text);

    /**
     * 查询任务结果
     */
    abstract function fetchTaskResult($taskId);
}
