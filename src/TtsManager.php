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

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class TtsManager implements ClientResolverInterface
{
    protected $clients = [];

    protected $factory;

    public function __construct()
    {
        $this->factory = new TtsClientFactory();
    }

    public function client($name = null)
    {
        $name = $this->parseClientName($name);
        if (! isset($this->clients[$name])) {
            $this->clients[$name] = $this->makeClient($name);
        }

        return $this->clients[$name];
    }

    protected function parseClientName($name)
    {
        return $name ?: $this->getDefaultClient();
    }

    public function getDefaultClient()
    {
        return Config('tts.default');
    }

    public function setDefaultClient($name)
    {
        Config::set('tts.default', $name);
    }

    /**
     * Get the configuration for a client
     *
     * @param $name
     * @return mixed
     */
    protected function configuration($name)
    {
        $name = $name ?: $this->getDefaultClient();

        $clients = Config('tts.clients');

        if (is_null($config = Arr::get($clients, $name))) {
            throw new \InvalidArgumentException("client [{$name}] not configured.");
        }

        return $config;
    }

    protected function makeClient($name)
    {
        $config = $this->configuration($name);
        return $this->factory->make($config);
    }
}
