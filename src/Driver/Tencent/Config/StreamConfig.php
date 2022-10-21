<?php

/*
 * This file is part of easy-tts-laravel.
 *
 * (c) 王瑀轩 <xuan96124@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyTts\Driver\Tencent\Config;

use TencentCloud\Tts\V20190823\Models\TextToVoiceRequest;

class StreamConfig extends TextToVoiceRequest
{
    public function __construct($config = [])
    {
        $config += [
            'ModelType' => 1,
            'Volume' => 0,
            'Speed' => 1,
            'ProjectId' => 0,
            'VoiceType' => 10510000,
            'PrimaryLanguage' => 1,
            'SampleRate' => 16000,
            'Codec' => 'mp3',
            'SessionId' => "\\random_bytes(16)\\",
        ];

        $this->ModelType = $config['ModelType'];
        $this->Volume = $config['Volume'];
        $this->Speed = $config['Speed'];
        $this->ProjectId = $config['ProjectId'];
        $this->VoiceType = $config['VoiceType'];
        $this->PrimaryLanguage = $config['PrimaryLanguage'];
        $this->SampleRate = $config['SampleRate'];
        $this->Codec = $config['Codec'];
        $this->SessionId = $config['SessionId'];

        parent::__construct();
    }
}
