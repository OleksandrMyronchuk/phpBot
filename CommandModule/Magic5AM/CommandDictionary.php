<?php
require_once ABSPATH . 'CommandModule/Magic5AM/CommandStart2.php';
require_once ABSPATH . 'CommandModule/Magic5AM/CommandCancel.php';
require_once ABSPATH . 'CommandModule/Magic5AM/Time.php';
require_once ABSPATH . 'CommandModule/Magic5AM/Debug.php';

$cdForMagic5AM = array(
    array( 'command' => 'start', 'className' => 'CommandStart2'),
    array( 'command' => 'cancel', 'className' => 'CommandCancel'),
    array( 'command' => 'time', 'className' => 'Time'),
    array( 'command' => 'debug-status', 'className' => 'Debug'),
    array( 'command' => 'debug-ignore-time-on', 'className' => 'Debug'),
    array( 'command' => 'debug-ignore-time-off', 'className' => 'Debug'),
    array( 'command' => 'debug-ignore-duplicate-on', 'className' => 'Debug'),
    array( 'command' => 'debug-ignore-duplicate-off', 'className' => 'Debug')
);
