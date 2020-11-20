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

    function InsertReceivedMediaFile($objStructReceivedMediaFile)
    {
        global $db;
        $names = [
            '_message_id',
            '_date',
            '_file_id',
            '_file_unique_id',
            '_user_id'
        ];
        $values = [
            $objStructReceivedMediaFile->message_id,
            $objStructReceivedMediaFile->date,
            $objStructReceivedMediaFile->file_id,
            $objStructReceivedMediaFile->file_unique_id,
            $objStructReceivedMediaFile->user_id
        ];
        $db->Insert('_ReceivedMediaFile', $names, $values);
    }

    function GetAllMediaFile()
    {

    }
}
