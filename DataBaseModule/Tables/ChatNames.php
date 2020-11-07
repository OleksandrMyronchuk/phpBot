<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class ChatNames extends dbModule
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

    public function InsertChatName($chat_id, $chat_name)
    {
        global $db;

        $db->DeleteByUI(_ChatNames, '_chat_id', $chat_id);

        $names = [
            '_chat_id',
            '_chat_name'
        ];
        $values = [
            $chat_id,
            $chat_name
        ];
        $db->Insert('_ChatNames', $names, $values);
    }

    public function GetAllChatNames()
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/GetAllChatNames.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}