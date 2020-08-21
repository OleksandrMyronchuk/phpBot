<?php

define( 'ABSPATH', __DIR__ . '/../../' );

require_once ABSPATH . 'Tools/FileTools.php';

class TypeOfPackage {
    const Command = 0;
    const Addition = 1;
}

class Unpackaging
{
    private $pathToPackage;
    private $typeOfPackage;
    private $packageName;

    public function __construct($packageName)
    {
        $this->pathToPackage = getcwd() . '/' . $packageName;
        $this->packageName = $packageName;

         /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/$this->DoUnpackaging(); return;
        echo $this->pathToPackage;
        $zip = new ZipArchive;
        if ($zip->open($this->pathToPackage . '.zip') === TRUE) {
            mkdir($this->pathToPackage);
            $zip->extractTo($this->pathToPackage);
            $zip->close();
            echo 'ok';
            $this->DoUnpackaging();
        } else {
            echo 'failed';
        }
    }

    public function AssignType()
    {
        $pathToAbout = $this->pathToPackage . '/about.txt';
        $f = fopen($pathToAbout, 'r') or die('Error! Failed to open file');
        $line = fgets($f);
        $line = substr($line, 0, strlen($line) - 2);
        fclose($f);
        if($line == 'command')
        {
            $this->typeOfPackage = TypeOfPackage::Command;
        }
        elseif($line == 'addition')
        {
            $this->typeOfPackage = TypeOfPackage::Addition;
        }
        else
        {
            die('Error! Unknown package type');
        }
    }

    public function MakeMenu()
    {
        $pathToMenu = $this->pathToPackage . '/BotAdminPanel/Magic5AM/Menu.json';
        if(!file_exists($pathToMenu)) return;
        $menuContent = file_get_contents($pathToMenu);
        $menuContent = json_decode($menuContent, true);
        $tempMenu = file_get_contents(ABSPATH . 'Plugins/PaketManager/TemplatePartOfMenu.html');
        $tempSubmenu = file_get_contents(ABSPATH . 'Plugins/PaketManager/TemplatePartOfSubMenu.html');

        $menuResult = '';

        foreach ($menuContent['Menu'] as $menu)
        {
            $menuResult .= str_replace('[MENUNAME]', $menu['name'], $tempMenu) . PHP_EOL;

            $subMenuResult = '';
            foreach ($menuContent['SubMenu'] as $subMenu)
            {
                $subMenuResult .=
                    str_replace('[FILENAME]', ($subMenu['path'] == null ? $subMenu['fileName'] : $subMenu['path']),
                        str_replace('[MENUNAME]', $menu['name'],
                        str_replace('[SUBMENUNAME]', $subMenu['name'], $tempSubmenu)))
                    . PHP_EOL;
            }

            $menuResult = str_replace('[CONTENT]', $subMenuResult, $menuResult);
        }

        file_put_contents(
            ABSPATH . 'BotAdminPanel/' .  $this->packageName . '/Menu.php',
            $menuResult);
    }

    public function MergeCommand()
    {
        $pathToPC = ABSPATH . 'CommandModule/ProcessCommand.php';
        $search = '$commandDictionary = array_merge';
        $a = FileTools::FindLineByText($pathToPC, $search);

        echo $a['content'];
        /*
        find $commandDictionary = array_merge
        get row number
        find ) in row
        replace to  cdFor[plugin name]
         */
    }

    public function IncludeCommand()
    {
        $pathToPC = ABSPATH . 'CommandModule/ProcessCommand.php';
        $contentOfPC = file_get_contents($pathToPC);
        $includeLine =
            '<?php' .
            PHP_EOL .
            'require_once ABSPATH . \'CommandModule/' .
            $this->packageName .
            '/CommandDictionary.php\';';
        $contentOfPC = str_replace('<?php', $includeLine, $contentOfPC);
        file_put_contents($pathToPC, $contentOfPC);
    }

    public function MakeCommand()
    {
        $pathToCommand = $this->pathToPackage . '/CommandModule/Magic5AM/ListOfCommands.json';

        if(!file_exists($pathToCommand)) return;
        $commandContent = file_get_contents($pathToCommand);
        $commandContent = json_decode($commandContent, true);

        $commandResult = '<?php' . PHP_EOL .
        '$cdFor' . $this->packageName . ' = array(\'';

        $commandResult .= implode('\', \'', $commandContent['commands']);

        $commandResult .= '\');'  . PHP_EOL . '?>';

        file_put_contents(
            ABSPATH . 'CommandModule/' .  $this->packageName . '/CommandDictionary.php',
            $commandResult);
    }

    public function MakeDeleteFile()
    {

    }

    /*
            if()
                if()

                    ...
        Отримати ебаут / зясувати тип файлу
        якщо команда
        отримати меню
        лист команд
        створити делете лист

        якщо додаток
        в плагіни помистити шіітс
        адмін панель
        дбмодуль
        інстал
        ресурс
        структура
           */

    public function GetPathToCopy($pathToFile)
    {
        $pluginPath = realpath( $pathToFile );
        $pluginPath = str_replace( '\\', '/', $pluginPath );
        $phpBotPath = str_replace( '/Plugins/PaketManager/Magic5AM', '', $pluginPath );

        //echo $pluginPath . PHP_EOL . '<br>' . $phpBotPath . PHP_EOL . '<br><br>';

        return array('pluginPath' => $pluginPath, 'phpBotPath' => $phpBotPath);
    }

    public function CreateDir($pathToFile)
    {
        $a = $this->GetPathToCopy($pathToFile);

        FileTools::CreateDirIfNotExist($a['phpBotPath']);
    }

    public function MoveFiles($pathToFile)
    {
        $a = $this->GetPathToCopy($pathToFile);

        copy($a['pluginPath'], $a['phpBotPath']);
    }

    public function DoUnpackaging()
    {
        //$this->AssignType();

        //$this->MakeMenu();

        //$this->MakeCommand();

        //$this->IncludeCommand();

        $this->MergeCommand();

        return;
        FileTools::RecursiveAllDirs($this->pathToPackage, 'CreateDir', $this);
        FileTools::RecursiveAllFiles($this->pathToPackage, 'MoveFiles', $this);
    }
}

new Unpackaging('Magic5AM');