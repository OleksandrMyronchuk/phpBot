<?php
require_once 'Auth.php';
isLogged('login.html');
require_once 'Define.php';
require_once ABSPATH . 'Logs/LogReader.php';

if(!empty($_POST['fileName']))
{
    $fileName = $_POST['fileName'];
    echo LogReader($fileName);
}