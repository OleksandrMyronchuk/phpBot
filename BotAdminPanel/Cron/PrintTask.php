<?php
require_once __DIR__ . '/../Define.php';
require_once ABSPATH . 'BotAdminPanel/Cron/Tasks.php';

$objTasks = new Tasks();
echo $objTasks->PrintReport();