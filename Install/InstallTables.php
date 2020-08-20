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

        $this->InstallReceivedMessage();
        $this->InstallSentMessage();
    }

    private function InstallPHPAuth()
    {
        $cmd = file_get_contents(ABSPATH . 'BotAdminPanel/PHPAuth/database_defs/database_mysql.sql');
        $this->Execute($cmd);
    }

    private function InstallSentMessage()
    {
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CREATE_TABLE_SentMessage.sql');
        $this->Execute($cmd);
    }

    private function InstallReceivedMessage()
    {
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CREATE_TABLE_ReceivedMessage.sql');
        $this->Execute($cmd);
    }
}