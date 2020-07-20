<?php
require_once __DIR__ . '/DBConnection.php';
require_once __DIR__ . '/PHPAuth/Config.php';
require_once __DIR__ . '/PHPAuth/Auth.php';

global $db;

$config = new PHPAuth\Config($db->pdo);
$auth   = new PHPAuth\Auth($db->pdo, $config);

$hash = $auth->getCurrentSessionHash();
$auth->logout($hash);
header('Location: login.html');