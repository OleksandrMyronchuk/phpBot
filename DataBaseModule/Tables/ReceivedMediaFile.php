<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';
require_once ABSPATH . 'StructureModule/StructUser.php';
require_once ABSPATH . 'StructureModule/Photo/StructReceivedMediaFile.php';

class ReceivedMediaFile extends dbModule
{
    public function __construct()
    {
        global $db;
        if($db==null)
        {
            parent::__construct();
            $this->ConnectToDB();
            $db = $this;
        }
    }
}

