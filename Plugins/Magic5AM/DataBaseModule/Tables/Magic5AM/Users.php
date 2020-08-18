<?php


class Users
{
    public function InsertUser($receivedMessage)
    {
        global $db;

        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/CheckIfUserExist.sql');

        $pdoStatement = $db->pdo->prepare($cmd);
        $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);

        $pdoStatement->execute();

        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if($result['NumberOfUsers'] == 0)
        {
            $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/InsertUser.sql');

            $pdoStatement = $db->pdo->prepare($cmd);

            $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);
            $pdoStatement->bindParam(':_Username', $receivedMessage->username, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_FirstName', $receivedMessage->first_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_LastName', $receivedMessage->last_name, PDO::PARAM_STR);

            $pdoStatement->execute();
        }
        else
        {
            $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/UpdateUser.sql');

            $pdoStatement = $db->pdo->prepare($cmd);

            $pdoStatement->bindParam(':_UserId', $receivedMessage->user_id, PDO::PARAM_INT);
            $pdoStatement->bindParam(':_Username', $receivedMessage->username, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_FirstName', $receivedMessage->first_name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':_LastName', $receivedMessage->last_name, PDO::PARAM_STR);

            $pdoStatement->execute();
        }
    }
}