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

use Illuminate\Support\Str;

class TtsClientFactory
{
    public function make(array $config)
    {
        return $this->createClient($config['driver'], $config['appid'], $config['secret_id'], $config['secret_key']);
    }

    protected function createClient(string $driver, $appId, $secretId, $secretKey): TtsClient
    {
        $className = __NAMESPACE__ . "\\Driver\\" . Str::ucfirst(strtolower($driver)) . "\\Client";
        try {
            $refClass = new \ReflectionClass($className);
            return $refClass->newInstance($appId, $secretId, $secretKey);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("Unsupported driver [{$driver}]");
        }
    }
}
