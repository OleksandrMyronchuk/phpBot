<?php

require_once ABSPATH . 'DataBaseModule/Tables/ReceivedMessage.php';
require_once ABSPATH . 'Resource/Magic5AM/Text/CommandPhraseModule.php';
require_once ABSPATH . 'CommandModule/AbstractCommand.php';
require_once ABSPATH . 'StructureModule/Sheets/StructGoogleSheets.php';
require_once ABSPATH . 'Addition/Sheets/GoogleSheetsMain.php';
require_once ABSPATH . 'DataBaseModule/Tables/Magic5AM/Users.php';
require_once ABSPATH . 'DataBaseModule/Tables/Magic5AM/UsersDays.php';
require_once ABSPATH . 'DebugTools/Magic5AM/DebugForStartCommand.php';
require_once ABSPATH . 'DataBaseModule/Tables/Magic5AM/DataToExport.php';
require_once ABSPATH . 'DataBaseModule/Tables/SentMessage.php';
require_once ABSPATH . 'Defines.php';

class CommandStart2 extends AbstractCommand
{
    private $objCommandPhraseModule;
    /* обмеження по часу */
    private $minAction = "03:00";
    private $maxAction = "05:31";
    private $deleteCallback;

    function __construct($receivedMessage, $cmd, $deleteCallback)
    {
        $this->deleteCallback = $deleteCallback;
        parent::__construct($receivedMessage, $cmd);
    }

    function ExecuteCommand()
    {
        $this->objReceivedMessage = new ReceivedMessage();
        $this->objCommandPhraseModule = new CommandPhraseModule('CommandStart');

        switch ($this->cmd->step)
        {
            case 0: return $this->Start();
            case 1: return $this->GetPlanForDay();
        }
    }

    private function PrepareSentMessage($text_id)
    {
        global $objSM;
        $objSM->command = $this->cmd->command;
        $objSM->step = $this->cmd->step;
        $objSM->to_user_id = $this->receivedMessage->user_id;
        $objSM->text_id = $text_id;
    }

    public function SetDeleteCallback($deleteCallback)
    {
        $this->deleteCallback = $deleteCallback;
    }

    private function DeleteStartCommand()
    {
        $objSM = new SentMessage();

        $startCMI = $objSM->GetStartCommandMessageInfo($this->receivedMessage->user_id);

        foreach ($startCMI as $part)
        {
            $result = call_user_func_array(
                $this->deleteCallback,
                array($part['_chat_id'], $part['_message_id'])
            );
            file_get_contents( $result );
        }

        $objSM->DeleteCommandMessageInfo($this->receivedMessage->user_id);
    }

    protected function Start()
    {
        global $allow_incorrect_time;
        if(DEBUGMODE == 1 && $allow_incorrect_time == 0) {
        $beginTime = strtotime($this->minAction);
        $endTime = strtotime($this->maxAction);
        $nowTime = $this->receivedMessage->date;
        if (!($endTime > $nowTime && $nowTime > $beginTime)) {
            return $this->objCommandPhraseModule->GetExceptionById(1);
        }
        }

        $userObj = new Users();
        $userObj->InsertUser($this->receivedMessage);/*Check if user not exist then add the user*/

        $userDayObj = new UsersDays();
        $currentDayArr = $userDayObj->GetCurrentDay($this->receivedMessage->user_id);/*Get current day without increment */

        $this->InsertMessageAI();

        global $allow_duplicate;

        if(DEBUGMODE == 1 && $allow_duplicate == 0) {
            $limitToNewRequest = 3600 * 19;
            if ((time() - $currentDayArr['_DateOfLastUpdate']) < $limitToNewRequest) {
                return $this->objCommandPhraseModule->GetExceptionById(2) ;
            }
        }

        $currentDay = $currentDayArr['_CurrentDay'];
        $response = $currentDay == 1 ? 0 : 2;
        $this->PrepareSentMessage($response);

        return sprintf($this->objCommandPhraseModule->GetPhraseById($response), $currentDayArr['_CurrentDay']);//process
    }

    private function PrepareDataToSend()
    {
        $GS = new StructGoogleSheets();
        $GS->userId = $this->receivedMessage->user_id;
        $GS->userName = $this->receivedMessage->username;
        $GS->firstName = $this->receivedMessage->first_name;
        $GS->lastName = $this->receivedMessage->last_name;
        $GS->telegramTime = date(TIMEFORMAT, ($this->receivedMessage->date + (TIMEOFFSET * 3600)));
        $GS->serverTime = date(TIMEFORMAT, strtotime('+' . TIMEOFFSET . 'hours'));
        $userDayObj = new UsersDays();
        $GS->day = $userDayObj->GetCurrentDay($this->receivedMessage->user_id)['_CurrentDay'];
        $GS->context = $this->receivedMessage->text;
        return $GS;
    }

    private function Finish()
    {
        $this->cmd->step = -1;
        $this->InsertMessage();

        $userDayObj = new UsersDays();
        $userDayObj->IncreaseDay($this->receivedMessage->user_id);

        $GS = $this->PrepareDataToSend();

        /*Save to DB*/
        $dteObj = new DataToExport();
        $dteObj->InsertMessage($GS);

        $currentDayArr = $userDayObj->GetCurrentDay($this->receivedMessage->user_id);/*Get current day without increment */
        $currentDay = $currentDayArr['_CurrentDay'];
        $response = $currentDay == 1 ? 1 : 3;
        $this->PrepareSentMessage($response);

        //$this->DeleteStartCommand();


        return $this->objCommandPhraseModule->GetPhraseById($response);
    }

    protected function GetPlanForDay()
    {
        $pattern = '/(1[012]|[1-9])(:|\.)[0-5][0-9](\\s)?(?i)(am|pm)|(([01]?[0-9]|2[0-3])(:|\.)[0-5][0-9])/i';
        $subject = $this->receivedMessage->text;

        if (1 == preg_match($pattern, $subject, $matches)) {
            return $this->Finish();
        } else {

            $this->PrepareSentMessage('Error');
            return $this->objCommandPhraseModule->GetExceptionById(0);
        }
    }
}