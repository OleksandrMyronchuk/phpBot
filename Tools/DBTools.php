<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class DBTools
{
    public static function CheckDBConnection()
    {
        $db = new DBModule();
        $db->ConnectToDB();
        try {
            $result = $db->Execute('SELECT version() AS version');
            return json_encode( array( 'status' => 'true', 'result' => $result['version'] ) );
        }
        catch (Exception $e)
        {
            return json_encode( array( 'status' => 'false', 'result' => ('Error: ' . $e->getMessage()) ) );
        }
    }
}