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

class ExcelReport extends AbstractExport
{
    function PrintReport()
    {
        $currentData = $this->GetData();

        $fp = fopen('php://output', 'w');

        foreach ($currentData as $part) {
            fputcsv($fp, $part);
        }

        fclose($fp);
    }
}

$objExcel = new ExcelReport();

$objExcel->beginDate = $_POST['beginDate'];
$objExcel->endDate = $_POST['endDate'];

$objExcel->CheckForEmptiness();

echo $objExcel->PrintReport();