<h1 align="center">Easy Tts For Laravel</h1>

<p align="center"> 一款满足你的多种TTS平台调用组件</p>

<p align="center">
<a href="https://packagist.org/packages/raison/easy-tts-laravel"><img src="https://poser.pugx.org/overtrue/easy-sms/license" alt="License"></a>
</p>


## 特点

1. 支持目前市面多家服务商
1. 一套写法兼容所有平台
1. 支持实时流式返回（短文本）创建异步任务（长文本）
1. 支持多种参数设置
1. 更多等你去发现与改进...

## 平台支持

- [科大讯飞 Tts](https://www.xfyun.cn/services/online_tts)
- [腾讯云 Tts](https://cloud.tencent.com/product/tts)
- [阿里云 Tts](https://ai.aliyun.com/nls/tts)
- [百度云 Tts](https://ai.baidu.com/tech/speech)
- ...

## 环境需求

- PHP >= 7.4

## 安装

```shell
$ composer require raison/easy-tts-laravel
```

## 各平台配置说明

### 在 config/app.php 文件中设置服务提供者和别名。

```php
'providers' => [
    ....
    EasyTts\Providers\LaravelServiceProvider::class,
    ....
],
```
###请使用下面这条命令来发布配置文件

```shell
 php artisan vendor:publish --provider="EasyTts\Providers\LaravelServiceProvider"
```

### [科大讯飞](https://www.xfyun.cn/services/online_tts)

```php
'xunfei' => [
            'driver' => 'xunfei',
            'appid' => '',
            'secret_id' => '',
            'secret_key' => '',
        ],
```

### [腾讯云](https://cloud.tencent.com/product/tts)

```php
'tencent' => [
            'driver' => 'tencent',
            'appid' => '',
            'secret_id' => '',
            'secret_key' => '',
        ],
```

### [阿里云](https://ai.aliyun.com/nls/tts)

```php
'aliyun' => [
            'driver' => 'aliyun',
            'appid' => '',
            'secret_id' => '',
            'secret_key' => '',
        ],
```

### [百度云](https://ai.baidu.com/tech/speech)

```php
'baidu' => [
            'driver' => 'baidu',
            'appid' => '',
            'secret_id' => '',
            'secret_key' => '',
        ],
```


## 使用

```php
use EasyTts\TtsManager;

(new TtsManager())->client()->textToSpeechStream('PHP是全世界最好的语言');
```

### [科大讯飞](https://www.xfyun.cn/services/online_tts)

平台支持方式 `短文本(流返回)` 


`流式返回(短文本)`  [请求参数说明](https://www.xfyun.cn/services/online_tts)
```php
use EasyTts\TtsManager;

$text = "php是全世界最好的语言";
$config = [
            'speed' => 50,
            'volume' => 50,
            'vcn' => "xiaoyan",
        ];

return (new TtsManager())->client('xunfei')->setRequestConfig($config)->textToSpeechStream($text);
```

### [腾讯云](https://cloud.tencent.com/product/tts)

`流式返回(短文本)`  [请求参数说明](https://cloud.tencent.com/document/product/1073/57373)

```php
use EasyTts\TtsManager;

$text = "php是全世界最好的语言";
$config = [
            'Speed' => 0,
            'Volume' => 0,
            'VoiceType' => 10510000,
        ];

return (new TtsManager())->client('tencent')->setRequestConfig($config)->textToSpeechStream($text);
```

`创建任务 (长文本)`  [请求参数说明](https://cloud.tencent.com/document/product/1073/57373)

```php
use EasyTts\TtsManager;

$text = "php是全世界最好的语言";
$config = [
            'Speed' => 0,
            'Volume' => 0,
            'VoiceType' => 10510000,
        ];

// 创建异步任务
$task_id = (new TtsManager())->client('tencent')->setRequestConfig($config)->createTask($text);
// 通过任务id获取结果
$res = (new TtsManager())->client('tencent')->fetchTaskResult($task_id);
```

### [阿里云](https://ai.aliyun.com/nls/tts)

`流式返回(短文本)`  [请求参数说明](https://help.aliyun.com/document_detail/429509.html#sectiondiv-h8d-iax-ofm)

```php
use EasyTts\TtsManager;

$text = "php是全世界最好的语言";
$config = [
            'speech_rate' => 200,
            'voice' => 70,
            'voice' => "zhitian_emo",
        ];

return (new TtsManager())->client('aliyun')->setRequestConfig($config)->textToSpeechStream($text);
```

`创建任务 (长文本)`  [请求参数说明](https://help.aliyun.com/document_detail/130509.html#section-r1y-bhg-824)

```php
use EasyTts\TtsManager;

$text = "php是全世界最好的语言";
$config = [
            'speech_rate' => 200,
            'voice' => 70,
            'voice' => "zhitian_emo",
        ];

// 创建异步任务
$task_id = (new TtsManager())->client('aliyun')->setRequestConfig($config)->createTask($text);
// 通过任务id获取结果
$res = (new TtsManager())->client('aliyun')->fetchTaskResult($task_id);
```

### [百度云](https://ai.baidu.com/tech/speech)

`流式返回(短文本)`  [请求参数说明](https://ai.baidu.com/ai-doc/SPEECH/Qk38y8lrl)

```php
use EasyTts\TtsManager;

$text = "php是全世界最好的语言";
$config = [
            'spd' => 10,
            'vol' => 10,
            'per' => 3,
        ];

return (new TtsManager())->client('baidu')->setRequestConfig($config)->textToSpeechStream($text);
```

`创建任务 (长文本)`  [请求参数说明](https://ai.baidu.com/ai-doc/SPEECH/1ku59x8ey)

```php
use EasyTts\TtsManager;

$text = "php是全世界最好的语言";
$config = [
            'speed' => 10,
            'volume' => 10,
            'voice' => 3,
        ];

// 创建异步任务
$task_id = (new TtsManager())->client('baidu')->setRequestConfig($config)->createTask($text);
// 通过任务id获取结果
$res = (new TtsManager())->client('baidu')->fetchTaskResult($task_id);
```


## License

MIT