<?php


class CommandCancel extends AbstractCommand
{
    function ExecuteCommand()
    {
        $this->objReceivedMessage = new ReceivedMessage();
        $this->cmd->step = -2;
        $this->InsertMessage();
    }
}