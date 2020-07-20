<?php

require_once ABSPATH . 'DataBaseModule/Tables/ReceivedMessage.php';
require_once ABSPATH . 'Resource/PhraseModule.php';
require_once ABSPATH . 'CommandModule/AbstractCommand.php';
require_once ABSPATH . 'StructureModule/CustomStructure/StructGoogleSheets.php';
require_once ABSPATH . 'Sheets/GoogleSheetsMain.php';
require_once ABSPATH . 'DataBaseModule/Tables/Users.php';
require_once ABSPATH . 'DataBaseModule/Tables/UsersDays.php';
require_once ABSPATH . 'DebugTools/DebugForStartCommand.php';
require_once ABSPATH . 'DataBaseModule/Tables/DataToExport.php';
require_once ABSPATH . 'Defines.php';

class CommandStart2 extends AbstractCommand
{
    private $objPhraseModule;
    /* обмеження по часу */
    private $minAction = "03:00";
    private $maxAction = "05:31";

    function ExecuteCommand()
    {
        $this->objReceivedMessage = new ReceivedMessage();
        $this->objPhraseModule = new PhraseModule('CommandStart');

        switch ($this->cmd->step)
        {
            case 0: return $this->Start();
            case 1: return $this->GetPlanForDay();
        }
    }

    protected function Start()
    {
        global $allow_incorrect_time;
        if(DEBUGMODE == 1 && $allow_incorrect_time == 0) {
        $beginTime = strtotime($this->minAction);
        $endTime = strtotime($this->maxAction);
        $nowTime = $this->receivedMessage->date;
        if (!($endTime > $nowTime && $nowTime > $beginTime)) {
            return $this->objPhraseModule->GetExceptionById(1);
        }
        }

        $userObj = new Users();
        $userObj->InsertUser($this->receivedMessage);/*Check if user not exist then add the user*/

        $userDayObj = new UsersDays();
        $currentDay = $userDayObj->GetCurrentDay($this->receivedMessage->id);/*Get current day without increment */

        $this->InsertMessageAI();

        global $allow_duplicate;

        if(DEBUGMODE == 1 && $allow_duplicate == 0) {
            $limitToNewRequest = 3600 * 19;
            if ((time() - $currentDay['_DateOfLastUpdate']) < $limitToNewRequest) {
                return $this->objPhraseModule->GetExceptionById(2) ;
            }
        }

        return sprintf($this->objPhraseModule->GetPhraseById(0), $currentDay['_CurrentDay']);//process
    }

    private function PrepareDataToSend()
    {
        $GS = new StructGoogleSheets();
        $GS->userId = $this->receivedMessage->id;
        $GS->userName = $this->receivedMessage->username;
        $GS->firstName = $this->receivedMessage->first_name;
        $GS->lastName = $this->receivedMessage->last_name;
        $GS->telegramTime = date(TIMEFORMAT, ($this->receivedMessage->date + (TIMEOFFSET * 3600)));
        $GS->serverTime = date(TIMEFORMAT, strtotime('+' . TIMEOFFSET . 'hours'));
        $userDayObj = new UsersDays();
        $GS->day = $userDayObj->GetCurrentDay($this->receivedMessage->id)['_CurrentDay'];
        $GS->context = $this->receivedMessage->text;
        return $GS;
    }

    private function Finish()
    {
        $this->cmd->step = -1;
        $this->InsertMessage();

        $userDayObj = new UsersDays();
        $userDayObj->IncreaseDay($this->receivedMessage->id);

        $GS = $this->PrepareDataToSend();

        /*Save to DB*/
        $dteObj = new DataToExport();
        $dteObj->InsertMessage($GS);

        return $this->objPhraseModule->GetPhraseById(1);
    }

    protected function GetPlanForDay()
    {
        $pattern = '/(1[012]|[1-9])(:|\.)[0-5][0-9](\\s)?(?i)(am|pm)|(([01]?[0-9]|2[0-3])(:|\.)[0-5][0-9])/i';
        $subject = $this->receivedMessage->text;

        if (1 == preg_match($pattern, $subject, $matches)) {
            return $this->Finish();
        } else {
            return $this->objPhraseModule->GetExceptionById(0);
        }
    }
}