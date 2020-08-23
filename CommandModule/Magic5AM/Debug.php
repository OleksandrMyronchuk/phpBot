<?php
require_once ABSPATH . 'DebugTools/Magic5AM/DebugForStartCommand.php';

class Debug
{
    private $currentCommand;
    public function __construct($receivedMessage, $resultCmd, $currentCommand) {
        $this->currentCommand = str_replace('-', '_', $currentCommand);
    }
    public function ExecuteCommand()
    {
        return call_user_func_array (array($this, $this->currentCommand), array());
    }
    public function debug_status()
    {
        return GetStatue();
    }
    public function debug_ignore_time_on()
    {
        return SetIgnoreTime(1);
    }
    public function debug_ignore_time_off()
    {
        return SetIgnoreTime(0);
    }
    public function debug_ignore_duplicate_on()
    {
        return SetIgnoreDuplicate(1);
    }
    public function debug_ignore_duplicate_off()
    {
        return SetIgnoreDuplicate(0);
    }
}