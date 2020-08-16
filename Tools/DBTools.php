<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class DBTools
{
    public static function CheckDBConnection()
    {
        $db = new DBModule();
        $db->ConnectToDB();
        try {
            $result = $db->Query('SELECT version() AS version');
            return array( 'status' => 'true', 'result' => $result[0]['version'] );
        }
        catch (Exception $e)
        {
            return array( 'status' => 'false', 'result' => ('Error: ' . $e->getMessage()) );
        }
    }
}