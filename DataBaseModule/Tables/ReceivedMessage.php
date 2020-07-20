<?php

require_once ABSPATH . 'DataBaseModule/dbModule.php';
require_once ABSPATH . 'StructureModule/StructCommand.php';

class ReceivedMessage
{
    function GetLastMessageByUsername($id)
    {
        global $db;

        $CommandText = file_get_contents(ABSPATH . 'Resource/MySQLCommands/GetLastMessageByUsername.sql');

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_from_id', $id, PDO::PARAM_STR);

        $pdoStatement->execute();

        $result = $pdoStatement->fetch();

        if($result == null)
        {
            return null;
        }

        $obj = new StructCommand();

        $obj->command = $result['_command'];
        $obj->step = $result['_step'];

        return $obj;
    }

    function InsertMessage($receivedMessage, $cmd)
    {
        global $db;
        $names = [
            '_message_id',
            '_first_name',
            '_last_name',
            '_username',
            '_from_id',
            '_date',
            '_text',
            '_command',
            '_step'
        ];
        $values = [
            $receivedMessage->message_id,
            $receivedMessage->first_name,
            $receivedMessage->last_name,
            $receivedMessage->username,
            $receivedMessage->id,
            $receivedMessage->date,
            $receivedMessage->text,
            $cmd->command,
            $cmd->step
        ];
        $db->Insert('_ReceivedMessage', $names, $values);
    }
}