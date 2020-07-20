<?php
require_once __DIR__ . '/DBConnection.php';
require_once __DIR__ . '/PHPAuth/Config.php';
require_once __DIR__ . '/PHPAuth/Auth.php';

use PHPAuth\Config;
use PHPAuth\Auth;

function isLogged($pathTologinPage)
{
    global $db;
    
    $config = new Config($db->pdo);
    $auth = new Auth($db->pdo, $config);

    if (!$auth->isLogged()) {
        header('Location: ' . $pathTologinPage);
        exit();
    }
}
?>
