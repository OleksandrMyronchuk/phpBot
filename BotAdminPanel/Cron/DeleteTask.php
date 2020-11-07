<?php
require_once __DIR__ . '/../Define.php';
require_once ABSPATH . 'BotAdminPanel/Cron/Tasks.php';

$taskId = $_POST['taskId'];

if(!empty($taskId))
{
    $objTask = new Tasks();
    $objTask->DeleteTask($taskId);
}

/*
Зробити файл видалити / показати / нове
і клас роботи таск
? структуру
*/