<?php

class StructReceivedMessage extends StructUser
{
    private $objStructAbstractMessage;

    public $text;
    public $type;

    public function __construct()
    {
        $this->objStructAbstractMessage = new StructAbstractMessage;
    }

    public function __call($method, $args)
    {
        $this->objStructAbstractMessage->$method($args[0]);
    }
}