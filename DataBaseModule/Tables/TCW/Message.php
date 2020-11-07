<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class Message extends dbModule
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

    function DeleteById($id)
    {
        global $db;

        $CommandText = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/DeleteMessageById.sql');

        $pdoStatement = $db->pdo->prepare($CommandText);

        $pdoStatement->bindParam(':_id', $id, PDO::PARAM_STR);

        $pdoStatement->execute();
    }

    public function GetAllMessage()
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetAllMessage.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function SaveTextAndGetId($messageText)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/SaveText.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_MessageText', $messageText, PDO::PARAM_INT);

        $pdoStatement->execute();

        return $db->pdo->lastInsertId();
    }
}