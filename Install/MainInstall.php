<?php
require_once ABSPATH . 'Install/InstallDB.php';

class MainInstall
{
    function Install()
    {
        $obj = new InstallDB();
        $obj->Install();
    }
}

