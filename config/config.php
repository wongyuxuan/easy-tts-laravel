<?php

return [

    /*
    |--------------------------------------------------------------------------
    | tts平台配置
    |--------------------------------------------------------------------------
    |
    | 目前已经支持（阿里、腾讯、百度、讯飞）四个平台供你选择，
    | 你需要将各个平台的 appid、secret_id、 secret_key
    | 配置好即可开箱使用
    |
    */

    'default' => env('TTS_CLIENT', 'aliyun'),

    'clients' => [
        'aliyun' => [
            'driver' => 'aliyun',
            'appid' => env('ALIYUN_APPID', ''),
            'secret_id' => env('ALIYUN_SECRET_ID', ''),
            'secret_key' => env('ALIYUN_SECRET_KEY', ''),
        ],
        'baidu' => [
            'driver' => 'baidu',
            'appid' => env('BAIDU_APPID', ''),
            'secret_id' => env('BAIDU_SECRET_ID', ''),
            'secret_key' => env('BAIDU_SECRET_KEY', ''),
        ],
        'xunfei' => [
            'driver' => 'xunfei',
            'appid' => env('XUNFEI_APPID', ''),
            'secret_id' => env('XUNFEI_SECRET_ID', ''),
            'secret_key' => env('XUNFEI_SECRET_KEY', ''),
        ],
        'tencent' => [
            'driver' => 'tencent',
            'appid' => env('TENCENT_APPID', ''),
            'secret_id' => env('TENCENT_SECRET_ID', ''),
            'secret_key' => env('TENCENT_SECRET_KEY', ''),
        ],
    ]
];
