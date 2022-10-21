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

interface ClientResolverInterface
{
    /**
     * Get a tts client instance
     *
     * @param null $name
     * @return mixed
     */
    public function client($name = null);

    /**
     * get a default tts client name
     *
     * @return mixed
     */
    public function getDefaultClient();

    /**
     * set a default tts client name
     *
     * @return mixed
     */
    public function setDefaultClient($name);
}
