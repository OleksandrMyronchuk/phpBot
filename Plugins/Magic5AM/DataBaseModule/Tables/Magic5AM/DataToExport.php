<?php
require_once ABSPATH . 'DataBaseModule/dbModule.php';

class DataToExport
{
    function GetJSONDataToExport($beginDate, $endDate)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetCurrentDay.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_beginDate', $beginDate, PDO::PARAM_STR);
        $pdoStatement->bindParam(':_endDate', $endDate, PDO::PARAM_STR);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }

    function InsertMessage($data)
    {
        global $db;
        $names = [
            '_userId',
            '_username',
            '_firstName',
            '_lastName',
            '_telegramTime',
            '_serverTime',
            '_day',
            '_context'
        ];
        $values = [
            $data->userId,
            $data->userName,
            $data->firstName,
            $data->lastName,
            $data->telegramTime,
            $data->serverTime,
            $data->day,
            $data->context
        ];
        $db->Insert('_DataToExport', $names, $values);
    }
}