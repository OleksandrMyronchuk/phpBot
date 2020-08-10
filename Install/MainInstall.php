<?php
require_once ABSPATH . 'Install/InstallDB.php';

class MainInstall
{
    public function __construct()
    {
        if(!file_exists("Installed.txt"))
        {

        }
    }

    function Install()
    {
        $obj = new InstallDB();
        $obj->Install();
    }
}

