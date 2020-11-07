<?php
require_once __DIR__ . '/DBConnection.php';
require_once __DIR__ . '/PHPAuth/Config.php';
require_once __DIR__ . '/PHPAuth/Auth.php';

function isLogged($pathTologinPage)
{
    global $db;
    
    $config = new PHPAuth\Config($db->pdo);
    $auth = new PHPAuth\Auth($db->pdo, $config);

    if (!$auth->isLogged()) {
        header('Location: ' . $pathTologinPage);
        exit();
    }
}
?>
