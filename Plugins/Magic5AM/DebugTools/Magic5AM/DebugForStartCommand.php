<?php

require_once ABSPATH . 'Resource/Magic5AM/Text/CommandPhraseModule.php';

$allow_duplicate = null;
$allow_incorrect_time = null;

class DebugForStartCommand
{
    private $objCommandPhraseModule;

    public function __construct()
    {
        $this->objCommandPhraseModule = new CommandPhraseModule('CommandDebug');
    }

    function GetValues()
    {
        global $db;

        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/GetDebugSettingsForStartCommand.sql');

        $result = $db->pdo->query($cmd)->fetch(PDO::FETCH_ASSOC);

        global $allow_duplicate;
        global $allow_incorrect_time;

        $allow_duplicate = $result['_allow_duplicate'];
        $allow_incorrect_time = $result['_allow_incorrect_time'];
    }

    function SetIgnoreTime($isAllowIncorrectTime)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/SetIgnoreTime.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_allow_incorrect_time', $isAllowIncorrectTime, PDO::PARAM_BOOL);

        $pdoStatement->execute();
    }

    function SetIgnoreDuplicate($isAllowDuplicate)
    {
        global $db;
        $cmd = file_get_contents(ABSPATH . 'Resource/Magic5AM/SQL/SetIgnoreDuplicate.sql');

        $pdoStatement = $db->pdo->prepare($cmd);

        $pdoStatement->bindParam(':_allow_duplicate', $isAllowDuplicate, PDO::PARAM_BOOL);

        $pdoStatement->execute();
    }

    function GetStatue()
    {
        global $allow_duplicate;
        global $allow_incorrect_time;
        return sprintf($this->objCommandPhraseModule->GetPhraseById(0), $allow_incorrect_time, $allow_duplicate);
    }
}

$debugObj = null;

if(DEBUGMODE == 1)
{
    global $debugObj;
    $debugObj = new DebugForStartCommand();
    $debugObj->GetValues();
}

function GetStatue()
{
    global $debugObj;
    return $debugObj->GetStatue();
}

function SetIgnoreTime($isIgnore)
{
    global $debugObj;
    $debugObj->SetIgnoreTime($isIgnore);
}

function SetIgnoreDuplicate($isIgnore)
{
    global $debugObj;
    $debugObj->SetIgnoreDuplicate($isIgnore);
}