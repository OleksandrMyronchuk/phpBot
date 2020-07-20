<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';
require_once ABSPATH . 'BotAdminPanel/PHPAuth/Auth.php';
require_once ABSPATH . 'BotAdminPanel/PHPAuth/Config.php';

class InstallDB extends dbModule
{
    function Install()
    {
        $this->ConnectToDB();
        $this->InstallReceivedMessage();
        $this->InstallDebugSettingsForStart();
        $this->InstallUsers();
        $this->InstallUsersDays();
        $this->InstallDataToExport();
        $this->InstallPHPAuth();
        $this->Register();
    }

    private function InstallPHPAuth()
    {
        $cmd = file_get_contents(ABSPATH . 'BotAdminPanel/PHPAuth/database_defs/database_mysql.sql');
        $this->Execute($cmd);
    }

    private function InstallReceivedMessage()
    {
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CREATE_TABLE_ReceivedMessage.sql');
        $this->Execute($cmd);
    }

    private function InstallDebugSettingsForStart()
    {
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CREATE_TABLE_DebugSettingsForStart.sql');
        $this->Execute($cmd);
    }

    private function InstallUsers()
    {
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CREATE_TABLE_Users.sql');
        $this->Execute($cmd);
    }

    private function InstallUsersDays()
    {
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CREATE_TABLE_UsersDays.sql');
        $this->Execute($cmd);
    }

    private function InstallDataToExport()
    {
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CREATE_TABLE_DataToExport.sql');
        $this->Execute($cmd);
    }

    public function Register()
    {
        $config = new PHPAuth\Config($this->pdo);
        $auth = new PHPAuth\Auth($this->pdo, $config);

        $auth->register("magic5amclub@gmail.com", "magic2020_ElF", "magic2020_ElF");
    }
}