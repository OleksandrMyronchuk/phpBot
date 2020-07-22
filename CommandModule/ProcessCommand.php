<?php

require_once ABSPATH . 'StructureModule/StructCommand.php';
require_once ABSPATH . 'CommandModule/CommandStart2.php';
require_once ABSPATH . 'CommandModule/CommandCancel.php';
require_once ABSPATH . 'DataBaseModule/Tables/ReceivedMessage.php';
require_once ABSPATH . 'DebugTools/DebugForStartCommand.php';
require_once ABSPATH . 'Resource/PhraseModule.php';
require_once ABSPATH . 'Defines.php';

class ProcessCommand
{
    private $commandDictionary =
        [
            'start',
            'cancel',
            'time',
            'debug-status',
            'debug-ignore-time-on',
            'debug-ignore-time-off',
            'debug-ignore-duplicate-on',
            'debug-ignore-duplicate-off'
        ];
    private $type =
        [
            'private',
            'group',
            'supergroup',
            'channel'
        ];

    function ProcessCurrentCommand($receivedMessage)
    {
        if(!in_array($receivedMessage->type, $this->type)) {
            return ((new PhraseModule('CommandAll'))->GetExceptionById(0));
        }

        $resultCmd = '';

        $copyReceivedMessage = strtolower($receivedMessage->text);

        if('/' == $copyReceivedMessage[0])
        {
            $copyReceivedMessage = substr($copyReceivedMessage, 1);
        }
        elseif ('/' == $copyReceivedMessage[strlen($copyReceivedMessage)-1])
        {
            $copyReceivedMessage = substr($copyReceivedMessage, 0, -1);
        }

        if(in_array($copyReceivedMessage, $this->CommandDictionary))
        {
            $resultCmd = new StructCommand();
            $resultCmd->command = $receivedMessage->text;
            $resultCmd->step = 0;
        }
        else
        {
            $resultCmd = $this->GetCurrentCommand($receivedMessage->id);
        }

        /* Check if command is executing */
        if($resultCmd == null || $resultCmd->step < 0)
        {
            /* This message has been written not for the bot */
            return null;
        }

        $resultCmd->command = strtolower($resultCmd->command);

        switch ($resultCmd->command)
        {
            case 'start':
                $cmd = new CommandStart2($receivedMessage, $resultCmd, DeleteMessage);//make abstract
                return $cmd->ExecuteCommand();
            case 'cancel':
                $cmd = new CommandCancel($receivedMessage, $resultCmd);//make abstract
                return $cmd->ExecuteCommand();
            case 'time':
                return "Server time is " . date(TIMEFORMAT, strtotime('+' . TIMEOFFSET . ' hours')) .
                    "\nTelegram time is " . date(
                        TIMEFORMAT,
                        ($receivedMessage->date + (TIMEOFFSET * 3600))) .
                    "\nTime offset is " . TIMEOFFSET;
            case 'debug-status':
                return GetStatue();
            case 'debug-ignore-time-on':
                return SetIgnoreTime(1);
            case 'debug-ignore-time-off':
                return SetIgnoreTime(0);
            case 'debug-ignore-duplicate-on':
                return SetIgnoreDuplicate(1);
            case 'debug-ignore-duplicate-off':
                return SetIgnoreDuplicate(0);
        }
    }

    function GetCurrentCommand($id)
    {
        $obj = new ReceivedMessage();
        return $obj->GetLastMessageByUsername($id);
    }
}