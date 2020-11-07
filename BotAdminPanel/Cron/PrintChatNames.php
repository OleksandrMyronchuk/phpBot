<?php
require_once __DIR__ . '/../Define.php';
require_once ABSPATH . 'DataBaseModule/Tables/ChatNames.php';

$objChatNames = new ChatNames();
echo json_encode( $objChatNames->GetAllChatNames() );
