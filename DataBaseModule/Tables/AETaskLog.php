<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class AETaskLog extends dbModule
{
    public function __construct()
    {
        global $db;
        if($db==null)
        {
            parent::__construct();
            $this->ConnectToDB();
            $db = $this;
        }
    }

    public function InsertTaskLog($keyToAETask, $timeOfLastExecution)
    {
        global $db;
        $CommandText = file_get_contents(ABSPATH . 'Resource/MySQLCommands/InsertTaskLog.sql');

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_keyToAETask', $keyToAETask, PDO::PARAM_INT);
        $pdoStatement->bindParam(':_time_of_last_execution', $timeOfLastExecution, PDO::PARAM_STR);
        $pdoStatement->bindParam(':_time_of_last_execution2', $timeOfLastExecution, PDO::PARAM_STR);

        $pdoStatement->execute();
    }

    public function GetTimeByKeyToTask($keyToAETask)
    {
        global $db;

        $CommandText = file_get_contents(ABSPATH . 'Resource/MySQLCommands/GetTimeByKeyToTask.sql');

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_keyToAETask', $keyToAETask, PDO::PARAM_STR);

        $pdoStatement->execute();

        $result = $pdoStatement->fetch();

        return $result['_time_of_last_execution'] ?? null;
    }
}


/*
global $db;

        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CheckIfTaskLogExist.sql');

        $pdoStatement = $db->pdo->prepare($cmd);
        $pdoStatement->bindParam(':_keyToAETask', $keyToAETask, PDO::PARAM_INT);

        $pdoStatement->execute();

        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if($result['NumberOfUsers'] == 0)
        {
            $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/InsertUser.sql');

            $pdoStatement = $db->pdo->prepare($cmd);

            $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);
            $pdoStatement->bindParam(':_Username', $receivedMessage->username, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_FirstName', $receivedMessage->first_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_LastName', $receivedMessage->last_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_chat_id', $receivedMessage->chat_id, PDO::PARAM_STR);

            $pdoStatement->execute();
            return 'InsertUser';
        }
        else
        {
            $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/UpdateUser.sql');

            $pdoStatement = $db->pdo->prepare($cmd);

            $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);
            $pdoStatement->bindParam(':_Username', $receivedMessage->username, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_FirstName', $receivedMessage->first_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_LastName', $receivedMessage->last_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_chat_id', $receivedMessage->chat_id, PDO::PARAM_STR);

            $pdoStatement->execute();
            return 'UpdateUser';
        }
*/