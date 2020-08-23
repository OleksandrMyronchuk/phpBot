<?php


class Time
{
    private $receivedMessage;
    public function __construct($receivedMessage, $resultCmd, $currentCommand) {
        $this->receivedMessage = $receivedMessage;
    }
    public function ExecuteCommand()
    {
        return "Server time is " . date(TIMEFORMAT, strtotime('+' . TIMEOFFSET . ' hours')) .
            "\nTelegram time is " . date(
                TIMEFORMAT,
                ($this->receivedMessage->date + (TIMEOFFSET * 3600))) .
            "\nTime offset is " . TIMEOFFSET;
    }
}