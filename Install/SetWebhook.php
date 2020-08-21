<?php

define( 'ABSPATH', __DIR__ . '/../' );

require_once ABSPATH . 'Tools/FileTools.php';

$telegramSetWebhookPath = 'https://api.telegram.org/bot%s/setWebhook?url=%s';
$botToken = $_POST['botToken'];
$currentPathIndex = FileTools::Path2url(ABSPATH . 'index.php');

if(!empty($botToken))
{
    $url = sprintf($telegramSetWebhookPath, $botToken, $currentPathIndex);
    $result = json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
    if($result['ok'] == 'true' && $result['result'] == 'true')
    {
        echo $result['description'];
    }
    else
    {
        echo 'Error: ' . $result['error_code'] . ', ' . $result['description'];
    }
}