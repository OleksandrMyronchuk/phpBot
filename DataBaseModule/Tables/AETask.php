<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';
require_once ABSPATH . 'StructureModule/Cron/StructTask.php';

class AETask extends dbModule
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

    function DeleteTask($id)
    {
        global $db;

        $CommandText = file_get_contents(ABSPATH . 'Resource/MySQLCommands/DeleteTask.sql');

        $db->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_id', $id, PDO::PARAM_INT);
        $pdoStatement->bindParam(':_id2', $id, PDO::PARAM_INT);

        $pdoStatement->execute();
    }

    public function InsertTask($objNewTask)
    {
        global $db;
        $names = [
            '_chat_id',
            '_action_name',
            '_execution_time'
        ];
        $values = [
            $objNewTask->chatId,
            $objNewTask->action,
            $objNewTask->executionTime
        ];
        $db->Insert('_AETask', $names, $values);
    }

    public function GetAllAETasksWithChatNames()
    {
        global $db;
        $cmd = file_get_contents(
            ABSPATH . 'Resource/MySQLCommands/GetAllAETasksWithChatNames.sql'
        );

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function GetAllAETasks()
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/GetAllAETasks.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}