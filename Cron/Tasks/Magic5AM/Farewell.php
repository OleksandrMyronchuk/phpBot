<?php
require_once ABSPATH . 'Resource/Magic5AM/Text/CommandPhraseModule.php';

class Farewell
{
    public $CPM;
    public function __construct()
    {
        $this->CPM = new CommandPhraseModule('Farewell');
    }

    public function ExecuteCommand()
    {
        return $this->CPM->GetPhraseById(0);
    }
}