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

require_once 'Define.php';
require_once ABSPATH . '/DataBaseModule/dbModule.php';

if(empty($db)) {
    $db = new DBModule();
    $db->ConnectToDB();
}
