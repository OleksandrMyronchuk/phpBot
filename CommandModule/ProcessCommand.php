<?php
require_once ABSPATH . 'CommandModule/Magic5AM/CommandDictionary.php';

/*require_once ABSPATH . 'CommandModule/CommandStart2.php';
require_once ABSPATH . 'CommandModule/CommandCancel.php';
require_once ABSPATH . 'DataBaseModule/Tables/ReceivedMessage.php';
require_once ABSPATH . 'DebugTools/DebugForStartCommand.php';*/
require_once ABSPATH . 'StructureModule/StructCommand.php';
require_once ABSPATH . 'Resource/CommandPhraseModule.php';
require_once ABSPATH . 'Defines.php';

$commandDictionary = array_merge($cdForMagic5AM);
$classes = array_merge($classesForMagic5AM);

class ProcessCommand
{
    /*private $commandDictionary =
        [
            'start',
            'cancel',
            'time',
            'debug-status',
            'debug-ignore-time-on',
            'debug-ignore-time-off',
            'debug-ignore-duplicate-on',
            'debug-ignore-duplicate-off'
        ];*/
    private $type =
        [
            'private',
            'group',
            'supergroup',
            'channel'
        ];

    function GetCommand($text)
    {
        $text = strtolower($text);

        if('/' == $text[0])
        {
            $text = substr($text, 1);
        }
        elseif ('/' == $text[strlen($text)-1])
        {
            $text = substr($text, 0, -1);
        }

        return $text;
    }

    function ProcessCurrentCommand($receivedMessage)
    {
        if(!in_array($receivedMessage->type, $this->type)) {
            return ((new CommandPhraseModule('CommandAll'))->GetExceptionById(0));
        }

        $resultCmd = '';

        $copyReceivedMessage = $this->GetCommand($receivedMessage->text);

        if(in_array($copyReceivedMessage, $this->commandDictionary))
        {
            $resultCmd = new StructCommand();
            $resultCmd->command = $receivedMessage->text;
            $resultCmd->step = 0;
        }
        else
        {
            $resultCmd = $this->GetCurrentCommand($receivedMessage->user_id);
        }

        /* Check if command is executing */
        if($resultCmd == null || $resultCmd->step < 0)
        {
            /* This message has been written not for the bot */
            return null;
        }

        $resultCmd->command = $this->GetCommand($resultCmd->command);

        global $commandDictionary;
        foreach ($commandDictionary as $cmd) {
            if ($cmd == $resultCmd->command) {
                $cmd = eval('new ' . $classes[] . '($receivedMessage, $resultCmd, $resultCmd->command);');
                return $cmd->ExecuteCommand();
            }
        }

        /*switch ($resultCmd->command)
        {
            case 'start':
                $cmd = new CommandStart2($receivedMessage, $resultCmd, 'DeleteMessage');//make abstract
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
        }*/
    }

    function GetCurrentCommand($user_id)
    {
        $obj = new ReceivedMessage();
        return $obj->GetLastMessageByUsername($user_id);
    }
}