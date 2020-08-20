<?php

define( 'ABSPATH', __DIR__ . '/' );

/* install DB */
/*
require_once ABSPATH . 'Install/MainInstall.php';
(new MainInstall())->Install();
die;
*/

require_once ABSPATH . 'Defines.php';

$botToken = file_get_contents('botToken.txt');
define ('token', $botToken);
define ('base_url', 'https://api.telegram.org/bot' . token . '/');

require_once ABSPATH . 'dbConnect.php';

require_once ABSPATH . 'CommandModule/ProcessCommand.php';
require_once ABSPATH . 'StructureModule/StructReceivedMessage.php';
require_once ABSPATH . 'StructureModule/StructSentMessage.php';
/*require_once ABSPATH . 'DataBaseModule/Tables/SentMessage.php';*/

$input = file_get_contents('php://input');
$update = json_decode($input, JSON_OBJECT_AS_ARRAY);

$inputLog = fopen('inputLog.txt', 'a');
$logValue =
    '<input>\n' .
    '<time>\n' . date(TIMEFORMAT) . '\n</time>\n' .
    '<value>\n' . $input . '\n</value>\n' .
    '</input>\n\n';
fwrite($inputLog, $logValue);
fclose($inputLog);

/*
if (!empty($_GET['my']) && $_GET['my']=='read') {
    echo 'inputLog.txt contains:\n';
    $myfile = fopen("inputLog.txt", "r");
    echo fread($myfile,filesize("inputLog.txt"));
    fclose($myfile);
    die;
}
if (!empty($_GET['my']) && $_GET['my']=='read2') {
    echo 'log.txt contains:\n';
    $myfile = fopen('log.txt', "r") or die("Unable to open file!");
    echo fread($myfile,filesize('log.txt'));
    fclose($myfile);
    die;
}
*/

/*
$update = json_decode('{"update_id":682545269, "message":{"message_id":80,"from":{"id":669168176,"is_bot":false,'.
    '"first_name":"Oleksandr","last_name":"Myronchuk","username":"OleksandrMyronchuk","language_code":"en"},"chat":{'.
    '"id":669168176,"first_name":"Oleksandr","last_name":"Myronchuk","username":"OleksandrMyronchuk","type":"private"}'.
    ',"date":1593877630,"text":"start"}}', JSON_OBJECT_AS_ARRAY);
*/
/*
$update = json_decode('{"update_id":682546384, "message":{"message_id":1155,"from":{"id":669168176,"is_bot":false,"first_name":"Oleksandr","last_name":"Myronchuk","username":"OleksandrMyronchuk","language_code":"en"},"chat":{"id":669168176,"first_name":"Oleksandr","last_name":"Myronchuk","username":"OleksandrMyronchuk","type":"private"},"date":1595457745,"text":"dfk"}}'
    , JSON_OBJECT_AS_ARRAY);
*/

$objSM = new StructSentMessage();

try {

    function DeleteMessage($chat_id, $message_id)
    {
        return SendRequest(
            'deleteMessage',
            [
                'chat_id' => $chat_id,
                'message_id' => $message_id
            ]
        );
    }

    function SendRequest($method, $params = [])
    {
        $url = "";
        if (!empty($params)) {
            $url = base_url . $method . '?' . http_build_query($params);
        } else {
            $url = base_url . $method;
        }

        return $url;
    }

    $message = new StructReceivedMessage();

    if (null != $update) {
        $message->chat_id = $update['message']['chat']['id'];
        $message->type = $update['message']['chat']['type'];
        $message->message_id = $update['message']['message_id'];
        $message->first_name = $update['message']['from']['first_name'];
        $message->last_name = $update['message']['from']['last_name'];
        $message->username = $update['message']['from']['username'];
        $message->user_id = $update['message']['from']['id'];
        $message->date = $update['message']['date'];
        $message->text = $update['message']['text'];//'start';
        if($message->text == '') die;
//echo $message->text;
        $obj = new ProcessCommand();

        $answer = $obj->ProcessCurrentCommand($message);

        if($answer == null)
        {
            die;
        }

        $sendRequestResult = SendRequest(
            'sendMessage',
            [
                'chat_id' => $message->chat_id,
                'text' => $answer,
                'reply_to_message_id' => $message->message_id
            ]);
        //echo '$answer = ' . $answer;
        $answer = json_decode(file_get_contents($sendRequestResult), JSON_OBJECT_AS_ARRAY);

        $objSM->message_id = $answer['result']['message_id'];
        $objSM->chat_id = $answer['result']['chat']['id'];
        $objSM->date = $answer['result']['date'];

        $objTableSM = new SentMessage();
        $objTableSM->InsertMessage($objSM);
    }
}
catch (Exception $e)
{
    $error = $e->getMessage();
    $logValue =
        '<input>\n' .
        '<time>\n' . date(TIMEFORMAT) . '\n</time>\n' .
        '<value>\n' . $error . '\n</value>\n' .
        '</input>\n\n';
    $logFile = fopen('log.txt', 'a') or die;
    fwrite($logFile, $logValue);
    fclose($logFile);
}
?>