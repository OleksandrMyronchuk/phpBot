<?php

class Phrase
{
    private $pathToCommandPhrases = 'Resource/CommandPhrases';
    private $commandPhrases;
    public function __construct($commandName)
    {
        $this->commandPhrases =
            json_decode(file_get_contents($this->pathToCommandPhrases),
                JSON_OBJECT_AS_ARRAY)[$commandName];
    }

    public function GetPhraseById($id)
    {
        if(!empty($this->commandPhrases['Phrases'][$id])) {
            return $this->commandPhrases['Phrases'][$id];
        }
        else {
            return '';
        }
    }

    public function GetExceptionById($id)
    {
        if(!empty($this->commandPhrases['Exception'][$id])) {
            return $this->commandPhrases['Exception'][$id];
        }
        else {
            return '';
        }
    }
}