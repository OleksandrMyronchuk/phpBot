<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class DBTools
{
    public static function CheckDBConnection()
    {
        $db = new DBModule();
        $db->ConnectToDB();
    }
}