<?php

class StructSentMessage extends StructCommand
{
    private $objStructAbstractMessage;

    public $text_id;
    public $to_user_id;

    public function __construct()
    {
        $this->objStructAbstractMessage = new StructAbstractMessage;
    }

    public function __call($method, $args)
    {
        $this->objStructAbstractMessage->$method($args[0]);
    }
}