<?php


class StructGoogleSheets
{
    public $userId;
    public $userName;
    public $firstName;
    public $lastName;
    public $telegramTime;
    public $serverTime;
    public $day;
    public $context;

    public function GetUserId()
    {
        return empty($this->userId) ? ' - ' : $this->userId;
    }
    public function GetUserName()
    {
        return empty($this->userName) ? ' - ' : $this->userName;
    }
    public function GetFirstName()
    {
        return empty($this->firstName) ? ' - ' : $this->firstName;
    }
    public function GetLastName()
    {
        return empty($this->lastName) ? ' - ' : $this->lastName;
    }
    public function GetTelegramTime()
    {
        return empty($this->telegramTime) ? ' - ' : $this->telegramTime;
    }
    public function GetServerTime()
    {
        return empty($this->serverTime) ? ' - ' : $this->serverTime;
    }
    public function GetDay()
    {
        return empty($this->day) ? ' - ' : $this->day;
    }
    public function GetContext()
    {
        return empty($this->context) ? ' - ' : $this->context;
    }
}