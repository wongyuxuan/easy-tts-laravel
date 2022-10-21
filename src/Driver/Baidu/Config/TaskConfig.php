<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Driver\Baidu\Config;

use EasyTts\TtsConfigInterface;

class TaskConfig implements TtsConfigInterface
{
    /**
     * @var string 固定值zh。语言选择,目前只有中英文混合模式，填写固定值zh。 (必填)
     */
    private $lang = 'zh';

    /**
     * @var int 语速
     * 取值0-15，默认为5中语速
     */
    private $speed;

    /**
     * @var int 音调
     * 取值0-15，默认为5中语调
     */
    private $pitch;

    /**
     * @var int 音量
     * 取值0-15，默认为5中音量（取值为0时为音量最小值，并非为无声）
     */
    private $volume;

    /**
     * @var int 发音人(必填)
     * 可选值: 请到控制台添加试用或购买
     * 默认度逍遥
     */
    private $voice;

    /**
     * @var string 音频格式
     * "mp3-16k"，"mp3-48k"，"wav"，"pcm-8k"，"pcm-16k"，默认为mp3-16k
     */
    private $format;

    public function __construct($config = [])
    {
        $config += [
            'speed' => 5,
            'pitch' => 5,
            'volume' => 5,
            'voice' => 3,
            'format' => "mp3-16k",
        ];

        $this->speed = $config['speed'];
        $this->pitch = $config['pitch'];
        $this->volume = $config['volume'];
        $this->voice = $config['voice'];
        $this->format = $config['format'];
    }

    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'lang' => $this->lang,
            'speed' => $this->speed,
            'pitch' => $this->pitch,
            'volume' => $this->volume,
            'voice' => $this->voice,
            'format' => $this->format,
        ];
    }

    /**
     * 返回toArray的Json格式
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
