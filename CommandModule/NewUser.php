<?php


class NewUser
{
    private $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    function ExecuteCommand()
    {
        $objCommandPhraseModule = new CommandPhraseModule('NewUser');
        return sprintf($objCommandPhraseModule->GetPhraseById(0), $this->username);
    }

}