<?php
require_once ABSPATH . 'Install/InstallDB.php';
require_once ABSPATH . 'BotAdminPanel/PHPAuth/Auth.php';
require_once ABSPATH . 'BotAdminPanel/PHPAuth/Config.php';

class CreateSuperuser extends dbModule
{
    public function __construct()
    {
        parent::__construct();
        $this->ConnectToDB();
    }

    public function Register($email, $password)
    {
        $config = new PHPAuth\Config($this->pdo);
        $auth = new PHPAuth\Auth($this->pdo, $config);

        return $auth->register($email, $password, $password);
    }
}