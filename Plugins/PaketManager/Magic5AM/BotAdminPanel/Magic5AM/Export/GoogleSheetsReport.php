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
require_once ABSPATH . 'Sheets/GoogleSheetsMain.php';
require_once ABSPATH . 'StructureModule/CustomStructure/StructGoogleSheets.php';

class GoogleSheetsReport extends AbstractExport
{
    public $spreadsheetId;
    function PrintReport()
    {
        $currentData = $this->GetData();

        foreach ($currentData as $part)
        {
            $GS = new StructGoogleSheets();
            $GS->userId = $part['_userId'];
            $GS->userName = $part['_username'];
            $GS->firstName = $part['_firstName'];
            $GS->lastName = $part['_lastName'];
            $GS->telegramTime = $part['_telegramTime'];
            $GS->serverTime = $part['_serverTime'];
            $GS->day = $part['_day'];
            $GS->context = $part['_context'];
            SetNewRow($GS, $this->spreadsheetId);
        }

        echo 'Export has been completed. You can close this web-page.';
    }
}

$objGoogleSheets = new GoogleSheetsReport();

$objGoogleSheets->beginDate = $_POST['beginDate'];
$objGoogleSheets->endDate = $_POST['endDate'];
$objGoogleSheets->spreadsheetId = $_POST['spreadsheetId'];

$objGoogleSheets->CheckForEmptiness();

echo $objGoogleSheets->PrintReport();