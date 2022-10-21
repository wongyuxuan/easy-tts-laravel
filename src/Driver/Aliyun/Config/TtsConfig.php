<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Driver\Aliyun\Config;

use EasyTts\TtsConfigInterface;

class TtsConfig implements TtsConfigInterface
{
    /**
     * @var int 语速
     * 取值-500~500，默认为5中语速
     */
    private $speech_rate;

    /**
     * @var int 音调
     * 取值-500~500，默认为5中语调
     */
    private $pitch_rate;

    /**
     * @var int 音量
     * 取值-500~500，默认为5中音量（取值为0时为音量最小值，并非为无声）
     */
    private $volume;

    /**
     * @var string 发音人(必填)
     * 可选值: 请到控制台添加试用或购买
     * 默认 xiaoyun
     */
    private $voice;

    /**
     * @var string 音频格式
     * 音频编码格式，支持pcm/wav/mp3格式，默认是pcm
     */
    private $format;

    public function __construct($config = [])
    {
        $config += [
            'voice' => "xiaoyun",
            'speech_rate' => 0,
            'volume' => 50,
            'pitch_rate' => 0,
            'format' => "mp3",
        ];

        $this->voice = $config['voice'];
        $this->speech_rate = $config['speech_rate'];
        $this->volume = $config['volume'];
        $this->pitch_rate = $config['pitch_rate'];
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
            'voice' => $this->voice,
            'speech_rate'  => $this->speech_rate,
            'volume'  => $this->volume,
            'pitch_rate'  => $this->pitch_rate,
            'format'  => $this->format,
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
