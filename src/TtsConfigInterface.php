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

/**
 * tts 参数配置接口类
 */
interface TtsConfigInterface
{
    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray();

    /**
     * 返回toArray的Json格式
     *
     * @return string
     */
    public function toJson();
}
