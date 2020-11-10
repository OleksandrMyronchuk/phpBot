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
require_once ABSPATH . 'DataBaseModule/Tables/SentMessage.php';
require_once ABSPATH . 'DataBaseModule/Tables/ChatNames.php';

$input = file_get_contents('php://input');
$update = json_decode($input, JSON_OBJECT_AS_ARRAY);

$inputLog = fopen('inputLog.xml', 'a');
$logValue =
    '<input>' . PHP_EOL .
    '<time>' . PHP_EOL . date(TIMEFORMAT)  . PHP_EOL . '</time>'  . PHP_EOL .
    '<value>' . PHP_EOL . $input  . PHP_EOL . '</value>' . PHP_EOL .
    '</input>' . PHP_EOL . PHP_EOL;
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
$update = json_decode('{"update_id":682546456,
"message":{"message_id":1258,"from":{"id":669168176,"is_bot":false,"first_name":"Oleksandr","last_name":"Myronchuk","username":"OleksandrMyronchuk","language_code":"en"},"chat":{"id":669168176,"first_name":"Oleksandr","last_name":"Myronchuk","username":"OleksandrMyronchuk","type":"private"},"date":1598171837,'.
    '"text":"debug-status"}}', JSON_OBJECT_AS_ARRAY);
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
        $_message = $update['message'];

        if(array_key_exists('new_chat_member', $_message))
        {
            $username = null;
            $chat_id = $_message['chat']['id'];
            if($_message['new_chat_member']['username'] != '')
            {
                $username = $_message['new_chat_member']['username'];
            }
            else
            {
                $username = $_message['new_chat_member']['first_name'] . ' ' .
                    $_message['new_chat_member']['last_name'];
            }

            $obj = new ProcessCommand();
            $answer = $obj->NewUser($username);
            $sendRequestResult = SendRequest(
                'sendMessage',
                [
                    'chat_id' => $chat_id,
                    'text' => $answer
                ]);

            $answer = json_decode(file_get_contents($sendRequestResult), JSON_OBJECT_AS_ARRAY);
        }
        elseif (array_key_exists('photo', $_message))
        {
            $objPhoto = new StructPhoto();

            $objPhoto->message_id = $_message['message_id'];
            $objPhoto->first_name = $_message['from']['first_name'];
            $objPhoto->last_name = $_message['from']['last_name'];
            $objPhoto->username = $_message['from']['username'];
            $objPhoto->user_id = $_message['from']['id'];
            $objPhoto->date = $_message['date'];
            $objPhoto->file_id = $_message['photo'][0]['file_id'];
            $objPhoto->file_unique_id = $_message['photo'][0]['file_unique_id'];

            $obj = new ProcessCommand();
            $answer = $obj->SetPhoto($username);
            $sendRequestResult = SendRequest(
                'sendMessage',
                [
                    'chat_id' => $message->chat_id,
                    'text' => $answer,
                    'reply_to_message_id' => $message->message_id
                ]);

            $answer = json_decode(file_get_contents($sendRequestResult), JSON_OBJECT_AS_ARRAY);
        }
        else {

            $message->chat_id = $_message['chat']['id'];
            $message->type = $_message['chat']['type'];
            $message->message_id = $_message['message_id'];
            $message->first_name = $_message['from']['first_name'];
            $message->last_name = $_message['from']['last_name'];
            $message->username = $_message['from']['username'];
            $message->user_id = $_message['from']['id'];
            $message->date = $_message['date'];
            $message->text = $_message['text'];//'start';

            if ($message->text == '') die;
            //echo $message->text;
            $obj = new ProcessCommand();

            $answer = $obj->ProcessCurrentCommand($message);

            if ($answer == null) {
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

            $chat = $answer['result']['chat'];
            $chat_id = $chat['id'];
            $chat_name = null;
            if (array_key_exists('title', $chat)) {
                $chat_name = '[C] ' . $chat['title'];//C - chat
            } elseif (array_key_exists('username', $chat)) {
                $chat_name = $chat['username'] == '' ?
                    '[F/LN] ' . $chat['first_name'] . ' ' . $chat['last_name'] // First/LAst Name
                    :
                    '[U] ' . $chat['username']; // UserName
            }

            $objChatNames = new ChatNames();
            $objChatNames->InsertChatName($chat_id, $chat_name);
        }
    }
}
catch (Exception $e)
{
    $error = $e->getMessage();
    $logValue =
        '<input>' . PHP_EOL .
        '<time>' . PHP_EOL . date(TIMEFORMAT)  . PHP_EOL . '</time>' . PHP_EOL .
        '<value>' . PHP_EOL . $error  . PHP_EOL . '</value>' . PHP_EOL .
        '</input>' . PHP_EOL . PHP_EOL;
    $logFile = fopen('log.xml', 'a') or die;
    fwrite($logFile, $logValue);
    fclose($logFile);
}
?>