<?php


class SentMessage
{
    function DeleteCommandMessageInfo($userId)
    {
        global $db;

        $CommandText = file_get_contents(ABSPATH . 'Resource/MySQLCommands/DeleteCommandReceivedMessage.sql');

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_from_id', $userId, PDO::PARAM_STR);

        $pdoStatement->execute();

        global $db;

        $CommandText = file_get_contents(ABSPATH . 'Resource/MySQLCommands/DeleteCommandSentMessage.sql');

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_to_user_id', $userId, PDO::PARAM_STR);

        $pdoStatement->execute();
    }

    function GetStartCommandMessageInfo($userId)
    {
        global $db;

        $CommandText = file_get_contents(ABSPATH . 'Resource/MySQLCommands/GetStartCommandMessageInfo.sql');

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_to_user_id', $userId, PDO::PARAM_STR);
        $pdoStatement->bindParam(':_from_id', $userId, PDO::PARAM_STR);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll();

        return $result;
    }

    function InsertMessage($sentMessage)
    {
        global $db;
        $names = [
            '_message_id',
            '_chat_id',
            '_date',
            '_to_user_id',
            '_text_id',
            '_step',
            '_command'
        ];
        $values = [
            $sentMessage->message_id,
            $sentMessage->chat_id,
            $sentMessage->date,
            $sentMessage->to_user_id,
            $sentMessage->text_id,
            $sentMessage->step,
            $sentMessage->command
        ];
        $db->Insert('_SentMessage', $names, $values);
    }
}