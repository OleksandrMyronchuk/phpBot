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
require_once ABSPATH . 'BotAdminPanel/Export/AbstractExport.php';

class View extends AbstractExport
{
    function PrintReport()
    {
        $currentData = $this->GetData();
        return json_encode($currentData);
    }
}

$objView = new View();

$objView->beginDate = $_POST['beginDate'];
$objView->endDate = $_POST['endDate'];

$objView->CheckForEmptiness();

echo $objView->PrintReport();