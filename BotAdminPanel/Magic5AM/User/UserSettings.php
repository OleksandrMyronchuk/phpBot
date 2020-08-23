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
require_once __DIR__ . '/../../Define.php';
require_once ABSPATH . 'BotAdminPanel/DBConnection.php';

class UserSettings
{
    public static function  PrintUserInfo()
    {
        global $db;

        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetListOfCurrentDays.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->execute();

        return json_encode( $pdoStatement->fetchAll(PDO::FETCH_ASSOC) );
    }

    public static function SetDay($setDay, $userID)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/SetDayForUser.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_UserId', $userID, PDO::PARAM_INT);
        $pdoStatement->bindParam(':_CurrentDay', $setDay, PDO::PARAM_INT);

        $pdoStatement->execute();
    }
}

$setDay = empty($_POST['setDay']) ? null : $_POST['setDay'];
$userID = empty($_POST['userID']) ? null : $_POST['userID'];

if($setDay == null)
{
    echo UserSettings::PrintUserInfo();
    die;
}

UserSettings::SetDay($setDay, $userID);
