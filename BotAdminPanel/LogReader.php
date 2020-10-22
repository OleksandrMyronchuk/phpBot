<?php
require_once 'Auth.php';
isLogged('login.html');
require_once 'Define.php';
require_once ABSPATH . 'Logs/LogReader.php';

if(!empty($_POST['typeOfLog']))
{
    $typeOfLog = $_POST['typeOfLog'];
    if($typeOfLog == 'input')
    {
        echo nl2br(LogReader('inputLog.xml'));
    }
    elseif ($typeOfLog == 'error')
    {
        echo nl2br(LogReader('log.xml'));
    }
}