<?php

$botToken = file_get_contents(ABSPATH . 'botToken.txt');
define ('token', $botToken);
define ('base_url', 'https://api.telegram.org/bot' . token . '/');

class Web
{
    public static function DeleteMessage($chat_id, $message_id)
    {
        return Web::SendRequest(
            'deleteMessage',
            [
                'chat_id' => $chat_id,
                'message_id' => $message_id
            ]
        );
    }

    public static function GetFile($file_id)
    {
        return Web::SendRequest(
            'getFile',
            [
                'file_id' => $file_id
            ]
        );
    }

    public static function SendRequest($method, $params = [])
    {
        $url = "";
        if (!empty($params)) {
            $url = base_url . $method . '?' . http_build_query($params);
        } else {
            $url = base_url . $method;
        }

        return $url;
    }
}