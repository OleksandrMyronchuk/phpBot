<?php
/* at the top of '*.php' */
if ( $_SERVER['REQUEST_METHOD']=='GET' &&
    realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
{
    /*
       Up to you which header to send, some prefer 404 even if
       the files does exist for security
    */
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    die;
}
require_once __DIR__ . '/../Define.php';
require_once ABSPATH . 'BotAdminPanel/DBConnection.php';
require_once ABSPATH . 'BotAdminPanel/Abstract/AbstractDate.php';

class AbstractExport extends AbstractDate
{
    function GetData()
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/MySQLCommands/GetDataToExport.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_startDate', $this->beginDate, PDO::PARAM_STR);
        $pdoStatement->bindParam(':_endDate', $this->endDate, PDO::PARAM_STR);

        $pdoStatement->execute();

        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }
}