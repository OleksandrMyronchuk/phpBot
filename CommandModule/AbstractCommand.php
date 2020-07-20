<?php


class AbstractCommand
{
    protected $receivedMessage;
    protected $cmd;
    protected $objReceivedMessage = null;

    function __construct($receivedMessage, $cmd)
    {
        $this->receivedMessage = $receivedMessage;
        $this->cmd = $cmd;
    }

    function InsertMessageAI()/*Auto Increment*/
    {
        $this->cmd->step++;
        $this->objReceivedMessage->InsertMessage($this->receivedMessage, $this->cmd);
    }

    function InsertMessage()
    {
        $this->objReceivedMessage->InsertMessage($this->receivedMessage, $this->cmd);
    }
}