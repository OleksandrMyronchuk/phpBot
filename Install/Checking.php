<?php

define( 'ABSPATH', __DIR__ . '/../' );

require_once ABSPATH . 'Tools/DBTools.php';
require_once ABSPATH . 'Tools/TelegramTools.php';

$dbConnStatus = DBTools::CheckDBConnection();
$objTT = new TelegramTools();
$webhookInfo = $objTT->GetWebhookInfo();
$me = $objTT->GetMe();

$status = $webhookInfo['status'] && $me['status'] && $dbConnStatus['status'];

$description =
    json_encode($webhookInfo['result']) . '<br>' .
    json_encode($me['result']) . '<br>' .
    $dbConnStatus['result'];

echo json_encode(array('status'=>$status, 'description'=>$description));
