<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class Users extends dbModule
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

    public function GetUserInfo()
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetUserInfo.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function GetAllChatId()
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetAllChatId.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function GetToWhom($isSubscribed)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetToWhom.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_isSubscribed', $isSubscribed, PDO::PARAM_INT);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function DeleteUser($userId)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/DeleteSubscriber.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_UserId', $userId, PDO::PARAM_INT);

        $pdoStatement->execute();

        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/DeleteUser.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_UserId', $userId, PDO::PARAM_INT);

        $pdoStatement->execute();
    }

    public function GetUserById($user_id)
    {
        global $db;

        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetUserById.sql');

        $pdoStatement = $db->pdo->prepare($cmd);
        $pdoStatement->bindParam(':_UserId', $user_id, PDO::PARAM_INT);

        $pdoStatement->execute();

        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        return $result['_id'];
    }

    public function InsertUser($receivedMessage)
    {
        global $db;

        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/CheckIfUserExist.sql');

        $pdoStatement = $db->pdo->prepare($cmd);
        $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);

        $pdoStatement->execute();

        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if($result['NumberOfUsers'] == 0)
        {
            $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/InsertUser.sql');

            $pdoStatement = $db->pdo->prepare($cmd);

            $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);
            $pdoStatement->bindParam(':_Username', $receivedMessage->username, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_FirstName', $receivedMessage->first_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_LastName', $receivedMessage->last_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_chat_id', $receivedMessage->chat_id, PDO::PARAM_STR);

            $pdoStatement->execute();
            return 'InsertUser';
        }
        else
        {
            $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/UpdateUser.sql');

            $pdoStatement = $db->pdo->prepare($cmd);

            $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);
            $pdoStatement->bindParam(':_Username', $receivedMessage->username, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_FirstName', $receivedMessage->first_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_LastName', $receivedMessage->last_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_chat_id', $receivedMessage->chat_id, PDO::PARAM_STR);

            $pdoStatement->execute();
            return 'UpdateUser';
        }
    }
}