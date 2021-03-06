<?php

class UsersDays
{
    public function InsertDay($userId)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/InsertDay.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_UserId', $userId, PDO::PARAM_INT);

        $pdoStatement->execute();
    }

    public function IncreaseDay($userId)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/IncreaseDay.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_UserId', $userId, PDO::PARAM_INT);

        $pdoStatement->execute();
    }

    public function GetCurrentDay($userId)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetCurrentDay.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_UserId', $userId, PDO::PARAM_INT);

        $pdoStatement->execute();

        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if($result == null)
        {
            $this->InsertDay($userId);

            $result = [
                '_CurrentDay' => 1,
                '_DateOfLastUpdate' => null
            ];

            return $result;
        }
        return $result;
    }
}