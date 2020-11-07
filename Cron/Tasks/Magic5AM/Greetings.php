<?php
require_once ABSPATH . 'Resource/Magic5AM/Text/CommandPhraseModule.php';

class Greetings
{
    public $CPM;
    public function __construct()
    {
        $this->CPM = new CommandPhraseModule('Greetings');
    }

    public function ExecuteCommand()
    {
        return $this->CPM->GetPhraseById(0);
    }
}