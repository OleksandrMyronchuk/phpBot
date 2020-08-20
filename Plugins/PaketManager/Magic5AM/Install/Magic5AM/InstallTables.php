<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class InstallTables extends dbModule
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function Install()
    {
        $this->InstallDebugSettingsForStart();
        $this->InstallUsers();
        $this->InstallUsersDays();
        $this->InstallDataToExport();
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
}