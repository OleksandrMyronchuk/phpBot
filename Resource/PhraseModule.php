<?php

class PhraseModule
{
    private $pathToPhrases = 'Resource/Phrases';
    private $phrases;
    public function __construct($commandName)
    {
        $this->phrases = json_decode(file_get_contents($this->pathToPhrases), JSON_OBJECT_AS_ARRAY)[$commandName];
    }

    public function GetPhraseById($id)
    {
        if(!empty($this->phrases['Phrases'][$id])) {
            return $this->phrases['Phrases'][$id];
        }
        else {
            return '';
        }
    }

    public function GetExceptionById($id)
    {
        if(!empty($this->phrases['Exception'][$id])) {
            return $this->phrases['Exception'][$id];
        }
        else {
            return '';
        }
    }
}