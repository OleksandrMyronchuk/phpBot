<?php

/*
{"ok":true,"result":{"message_id":256,"from":{"id":1391902195,"is_bot":true,"first_name":"\u0421\u043c\u0430\u0447\u043d\u043eGO","username":"SmakGO_bot"},"chat":{"id":669168176,"first_name":"Oleksandr","last_name":"Myronchuk","username":"OleksandrMyronchuk","type":"private"},"date":1603727440,"text":"ok"}}
*/

/*
//get chat id from db


Make the share file for SENDMESSAGE

Make the table AETask
chat id for auto sending

id chatId/memberId actionName actionNumber serverTimeToRun

Make the table AETaskLog

id idto? time

Взяти все з таблиці AETask
перевірити в циклі чи інують такі файли
Tasks Dic php


*/
//set_error_handler(function() { /* ignore errors */ });

define( 'ABSPATH', __DIR__ . '/../' );

require_once ABSPATH . 'DataBaseModule/Tables/AETask.php';
require_once ABSPATH . 'DataBaseModule/Tables/AETaskLog.php';
require_once ABSPATH . 'Web/Web.php';
require_once ABSPATH . 'Defines.php';
require_once ABSPATH . 'Cron/Tasks/Magic5AM/TaskDictionary.php';

$objTask = new AETask();
$objTaskLog = new AETaskLog();

$tasks = $objTask->GetAllAETasks();

foreach ($tasks as $task)
{
    $execution_time = $task['_execution_time'];

    $sec_execution_time = strtotime($execution_time);

    if (
        (time() + 150) >= $sec_execution_time &&
        (time() - 150) < $sec_execution_time
    ) {
        $id = $task['_id'];
        $action_name = $task['_action_name'];
        $char_id = $task['_chat_id'];
        $objAction = null;
        eval('$objAction = new ' . $action_name . '();');
        $ec = $objAction->ExecuteCommand();

        $sendRequestResult = Web::SendRequest(
            'sendMessage',
            [
                'chat_id' => $char_id,
                'text' => $ec
            ]);

        try {

            $result = json_decode(
                file_get_contents($sendRequestResult),
                JSON_OBJECT_AS_ARRAY);

            if ($result['ok'] == true) {
                $currentTime = time();
                $objTaskLog->InsertTaskLog($id, $currentTime);
            }

        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}