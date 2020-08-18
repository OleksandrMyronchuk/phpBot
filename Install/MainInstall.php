<?php
require_once ABSPATH . 'Install/InstallTables.php';

class MainInstall
{
    public $fileInstalled = "Installed.txt";
    public function __construct()
    {
        if(!file_exists($this->fileInstalled))
        {
            $installed = fopen($this->fileInstalled, "w");
            $txt = "Tables have been installed.";
            fwrite($installed, $txt);
            fclose($installed);
            $this->Install();
        }
    }

    function Install()
    {
        $obj = new InstallTables();
        $obj->Install();
    }
}

