<?php
define( 'ABSPATH', __DIR__ . '/../' );

class ContentManager
{
    public $pathToBotToken;
    public $pathToDBConnect;

    public function __construct()
    {
        $this->pathToBotToken = ABSPATH . 'botToken.txt';
        $this->pathToDBConnect = ABSPATH . 'dbConnect.json';
    }

    function GetContent()
    {
        $botToken = $dbConnect = null;

        if (file_exists($this->pathToBotToken)) {
            $botToken = file_get_contents($this->pathToBotToken);
        }


        if (file_exists($this->pathToDBConnect)) {
            $dbConnect = file_get_contents($this->pathToDBConnect);
            $dbConnect = json_decode($dbConnect, true);
        }

        $result = array(
            'botToken' => $botToken,
            'databaseConnection' => $dbConnect
        );

        return json_encode($result);
    }

    function SaveContent($data)
    {
        $data = json_decode($data, true);
        file_put_contents($this->pathToBotToken, $data['botToken']);
        file_put_contents($this->pathToDBConnect, json_encode($data['databaseConnection']));
        echo 'ok6';
    }
}

if(!empty($_POST['functionName']))
{
    $obj = new ContentManager();
    $functionName = $_POST['functionName'];
    if($functionName == 'GetContent')
    {
        echo $obj->GetContent();
    }
    elseif($functionName == 'SaveContent')
    {
        $data = $_POST['data'];
        if(!empty($data)) {
            echo $obj->SaveContent($data);
        }
    }
}
