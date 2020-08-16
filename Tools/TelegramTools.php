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
        $result = str_replace('ok', 'status', file_get_contents($url));
        return json_decode($result, true);
    }

    public function GetMe()
    {
        $methodName = 'getMe';
        $url = sprintf($this->telegramInfoPath, $this->botToken, $methodName);
        $result = str_replace('ok', 'status', file_get_contents($url));
        return json_decode($result, true);
    }
}