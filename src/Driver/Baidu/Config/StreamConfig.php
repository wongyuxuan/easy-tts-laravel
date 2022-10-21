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

class StreamConfig implements TtsConfigInterface
{
    /**
     * @var string 用户唯一标识，用来计算UV值。(必填)
     */
    private $cuid;

    /**
     * @var int 客户端类型选择，web端填写固定值1。(必填)
     */
    private $ctp = 1;

    /**
     * @var string 固定值zh。语言选择,目前只有中英文混合模式，填写固定值zh。 (必填)
     */
    private $lan = 'zh';

    /**
     * @var int 语速
     * 取值0-15，默认为5中语速
     */
    private $spd;

    /**
     * @var int 音调
     * 取值0-15，默认为5中语调
     */
    private $pit;

    /**
     * @var int 音量
     * 取值0-15，默认为5中音量（取值为0时为音量最小值，并非为无声）
     */
    private $vol;

    /**
     * @var int 发音人(必填)
     * 可选值: 请到控制台添加试用或购买
     * 默认度逍遥
     */
    private $per;

    /**
     * @var string 音频格式
     * 3为mp3格式(默认)； 4为pcm-16k；5为pcm-8k；6为wav（内容同pcm-16k）
     */
    private $aue;

    public function __construct($config = [])
    {
        $config += [
            'cuid' => md5(random_bytes(16)),
            'spd' => 5,
            'pit' => 5,
            'vol' => 5,
            'per' => 3,
            'aue' => 3,
        ];

        $this->cuid = $config['cuid'];
        $this->spd = $config['spd'];
        $this->pit = $config['pit'];
        $this->vol = $config['vol'];
        $this->per = $config['per'];
        $this->aue = $config['aue'];
    }

    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'cuid' => $this->cuid,
            'ctp' => $this->ctp,
            'lan' => $this->lan,
            'spd' => $this->spd,
            'pit' => $this->pit,
            'vol' => $this->vol,
            'per' => $this->per,
            'aue' => $this->aue,
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
