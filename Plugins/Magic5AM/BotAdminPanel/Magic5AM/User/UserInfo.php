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
require_once ABSPATH . 'BotAdminPanel/Magic5AM/Abstract/AbstractDate.php';

class UserInfo extends AbstractDate
{
    public $enumAction;
    public function __construct()
    {
        $this->enumAction = [
            'Accept',
            'NotAccept',
            'All'
        ];
    }

    function PrintReport($action)
    {
        global $db;
        $path = null;

        if($this->enumAction[$action] == 'Accept')
        {
            $path = ABSPATH . 'Resource/Magic5AM/SQL/GetWhoAcceptMembers.sql';
        }
        elseif ($this->enumAction[$action] == 'NotAccept')
        {
            $path = ABSPATH . 'Resource/Magic5AM/SQL/GetWhoNotAcceptMembers.sql';
        }
        elseif ($this->enumAction[$action] == 'All')
        {
            $path = ABSPATH . 'Resource/Magic5AM/SQL/GetAllUsers.sql';
        }

        $cmd = file_get_contents($path);

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_startDate', $this->beginDate, PDO::PARAM_STR);
        $pdoStatement->bindParam(':_endDate', $this->endDate, PDO::PARAM_STR);

        $pdoStatement->execute();

        return json_encode( $pdoStatement->fetchAll(PDO::FETCH_ASSOC) );
    }
}

if($_POST['action'] == '')
{
    die;
}

$objUserInfo = new UserInfo();

$objUserInfo->beginDate = $_POST['beginDate'];
$objUserInfo->endDate = $_POST['endDate'];

$objUserInfo->CheckForEmptiness();

echo $objUserInfo->PrintReport($_POST['action']);
