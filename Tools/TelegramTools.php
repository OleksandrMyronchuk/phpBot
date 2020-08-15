<?php

class TelegramTools
{
    public $telegramInfoPath;
    public $botToken;

    public function __construct()
    {
        $this->telegramInfoPath = 'https://api.telegram.org/bot%s/%s';
        $botTokenPath = ABSPATH . 'botToken.txt';
        $this->botToken = file_get_contents($botTokenPath);
    }

    public function GetWebhookInfo()
    {
        $methodName = 'getWebhookInfo';
        $url = sprintf($this->telegramInfoPath, $this->botToken, $methodName);
        $result = json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
        if($result['ok'] == 'true')
        {
            print_r($result['result']);
        }
    }

    public function GetMe()
    {
        $methodName = 'getMe';
        $url = sprintf($this->telegramInfoPath, $this->botToken, $methodName);
        $result = json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
        if($result['ok'] == 'true')
        {
            print_r($result['result']);
        }
    }
}