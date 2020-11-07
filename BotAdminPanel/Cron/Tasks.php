<?php
require_once __DIR__ . '/../Define.php';

require_once ABSPATH . 'BotAdminPanel/Auth.php';
global $homepage;
isLogged($homepage . 'BotAdminPanel/login.html');

require_once ABSPATH . 'DataBaseModule/Tables/AETask.php';
require_once ABSPATH . 'StructureModule/Cron/StructTask.php';

class Tasks
{
    private $objAETask;
    private $objStructTask;

    function __construct()
    {
        $this->objAETask = new AETask();
    }

    function AddTask($chatId, $action, $executionTime)
    {
        $objStructTask = new StructTask();
        $objStructTask->chatId = $chatId;
        $objStructTask->action = $action;
        $objStructTask->executionTime = $executionTime;

        $this->objAETask->InsertTask($objStructTask);
    }

    function DeleteTask($taskId)
    {
        $this->objAETask->DeleteTask($taskId);
    }

    function PrintReport()
    {
        $objAETask = new AETask();
        return json_encode( $objAETask->GetAllAETasksWithChatNames() );
    }
}