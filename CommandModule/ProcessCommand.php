<?php
require_once ABSPATH . 'CommandModule/Magic5AM/CommandDictionary.php';

/*require_once ABSPATH . 'CommandModule/CommandStart2.php';
require_once ABSPATH . 'CommandModule/CommandCancel.php';
require_once ABSPATH . 'DataBaseModule/Tables/ReceivedMessage.php';
require_once ABSPATH . 'DebugTools/DebugForStartCommand.php';*/
require_once ABSPATH . 'CommandModule/NewUser.php';
require_once ABSPATH . 'StructureModule/StructCommand.php';
require_once ABSPATH . 'Resource/Phrase.php';
require_once ABSPATH . 'Defines.php';

$commandDictionary = array_merge($cdForMagic5AM);

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
        $text = mb_strtolower($text);

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
        /* Якщо немає типу то не виконуватися, а сказати про помилку */
        if(!in_array($receivedMessage->type, $this->type)) {
            return array('text' => (new Phrase('CommandAll'))->GetExceptionById(0));
        }

        $copyReceivedMessage = $this->GetCommand($receivedMessage->text);
        global $commandDictionary;

        foreach ($commandDictionary as $cmd) {

            if ($cmd['command'] == $copyReceivedMessage) {
                $resultCmd = new StructCommand();
                $resultCmd->command = $copyReceivedMessage;
                $resultCmd->step = 0;
                eval('$cmd = new ' . $cmd['className'] . '($receivedMessage, $resultCmd, $resultCmd->command);');
                return $cmd->ExecuteCommand();
            }
        }

        $resultCmd = $this->GetCurrentCommand($receivedMessage->user_id);

        /* Check if command is executing */
        if($resultCmd == null || $resultCmd->step < 0)
        {
            /* This message has been written not for the bot */
            return null;
        }

        $resultCmd->command = $this->GetCommand($resultCmd->command);

        foreach ($commandDictionary as $cmd) {
            if ($cmd['command'] == $resultCmd->command) {
                eval('$cmd = new ' . $cmd['className'] . '($receivedMessage, $resultCmd, $resultCmd->command);');
                return $cmd->ExecuteCommand();
            }
        }
        return null;
    }

    function GetCurrentCommand($user_id)
    {
        $obj = new ReceivedMessage();
        return $obj->GetLastMessageByUsername($user_id);
    }

    function SetMediaFile($structReceivedMediaFile)
    {
        $objMediaFile = new MediaFile($structReceivedMediaFile);
        return $objMediaFile->ExecuteCommand();
    }

    function NewUser($username)
    {
        $objNewUser = new NewUser($username);
        return $objNewUser->ExecuteCommand();
    }
}