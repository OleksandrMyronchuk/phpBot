<?php
require_once ABSPATH . 'DataBaseModule/Tables/ReceivedMediaFile.php';
require_once ABSPATH . 'Web/Web.php';

$botToken = file_get_contents(ABSPATH . 'botToken.txt');
define ('token', $botToken);

class MediaFile
{
    private $structReceivedMediaFile;

    public function __construct($structReceivedMediaFile)
    {
        $this->structReceivedMediaFile = $structReceivedMediaFile;
    }

    function ExecuteCommand($isLinkNeeded = true)
    {
        $objReceivedMediaFile = new ReceivedMediaFile();
        $objReceivedMediaFile->InsertReceivedMediaFile($this->structReceivedMediaFile);

        if($isLinkNeeded)
        {
            $answer = Web::GetFile($this->structReceivedMediaFile->file_id);

            /*$inputLog = fopen('inputLog370.xml', 'a');
            fwrite($inputLog, 'ok - '.$answer);
            fclose($inputLog);*/

            $r = json_decode(file_get_contents($answer), JSON_OBJECT_AS_ARRAY);

            return 'https://api.telegram.org/file/bot' .
                token . '/' .
                $r['result']['file_path'];
        }
        /*Зробити стандартну табличку для прийом фото
        зробити лінк для фото? - потім "завантажується" рис і підвантажувати
        return id as a result of the photo*/
        return null;
    }
}