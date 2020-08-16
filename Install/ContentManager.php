<?php
define( 'ABSPATH', __DIR__ . '/../' );

require_once ABSPATH . 'Install/MainInstall.php';
require_once ABSPATH . 'Install/CreateSuperuser.php';

class ContentManager
{
    public $pathToBotToken;
    public $pathToDBConnect;

    public function __construct()
    {
        $this->pathToBotToken = ABSPATH . 'botToken.txt';
        $this->pathToDBConnect = ABSPATH . 'dbConnect.json';
    }

    public function GetContent()
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

    public function SaveContent($data)
    {
        $data = json_decode($data, true);
        file_put_contents($this->pathToBotToken, $data['botToken']);
        file_put_contents($this->pathToDBConnect, json_encode($data['databaseConnection']));
    }

    public function InstallTables()
    {
        new MainInstall();
    }

    public function CreateSuperuser($email, $password)
    {
        $obj = new CreateSuperuser();
        return $obj->Register($email, $password);
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
            $result = $obj->SaveContent($data);
            $obj->InstallTables();
            echo $result;
        }
    }
    elseif($functionName == 'CreateSuperuser')
    {
        $email = $_POST['email'];
        /* ТУТ можна зробити краший захист. Public-key cryptography */
        $password = $_POST['password'];
        echo json_encode( $obj->CreateSuperuser($email, $password) );
    }
}
