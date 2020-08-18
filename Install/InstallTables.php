<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class InstallTables extends dbModule
{
    public function __construct()
    {
        parent::__construct();
        $this->ConnectToDB();
    }

    function Install()
    {
        $this->InstallPHPAuth();
    }

    private function InstallPHPAuth()
    {
        $cmd = file_get_contents(ABSPATH . 'BotAdminPanel/PHPAuth/database_defs/database_mysql.sql');
        $this->Execute($cmd);
    }
}