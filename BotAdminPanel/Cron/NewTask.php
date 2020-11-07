<?php
require_once __DIR__ . '/../Define.php';
require_once ABSPATH . 'BotAdminPanel/Cron/Tasks.php';

$chat_id = $_POST['chat_id'];
$action = $_POST['action'];
$execution_time = $_POST['execution_time'];

if(!(empty($chat_id) || empty($action) || empty($execution_time)))
{
    $objTask = new Tasks();
    $objTask->AddTask($chat_id, $action, $execution_time);
}