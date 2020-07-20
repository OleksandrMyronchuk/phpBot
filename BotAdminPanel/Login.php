<?php
require_once __DIR__ . '/DBConnection.php';
require_once __DIR__ . '/PHPAuth/Config.php';
require_once __DIR__ . '/PHPAuth/Auth.php';

global $db;

$config = new PHPAuth\Config($db->pdo);
$auth   = new PHPAuth\Auth($db->pdo, $config);

$verify = empty($_POST['username']) ||
empty($_POST['pass']) ||
empty($_POST['saveauth']);

if($verify)
{
    echo 'Fill in all fields!';
    die;
}

$username = $_POST['username'];
$pass = $_POST['pass'];
$saveauth = $_POST['saveauth'];

$result = $auth->login($username, $pass, $saveauth);

if (!$auth->isLogged()) {
    echo $result['message'];
    exit();
}
else
{
    echo '0';
}
?>
