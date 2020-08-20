<?php

define( 'ABSPATH', __DIR__ . '/../../' );

require_once ABSPATH . 'Tools/PathTools.php';

class TypeOfPackage {
    const Command = 0;
    const Addition = 1;
}

class Unpackaging
{
    private $pathToPackage;
    private $typeOfPackage;

    public function __construct($packageName)
    {
        $this->pathToPackage = getcwd() . '/' . $packageName;
         /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/$this->f(); return;
        echo $this->pathToPackage;
        $zip = new ZipArchive;
        if ($zip->open($this->pathToPackage . '.zip') === TRUE) {
            mkdir($this->pathToPackage);
            $zip->extractTo($this->pathToPackage);
            $zip->close();
            echo 'ok';
            $this->f();
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
            $this->typeOfPackage = new TypeOfPackage(TypeOfPackage::Command);
        }
        elseif($line == 'addition')
        {
            $this->typeOfPackage = new TypeOfPackage(TypeOfPackage::Addition);
        }
        else
        {
            die('Error! Unknown package type');
        }
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
    public function ff($pathToFile)
    {
        $a = realpath( $pathToFile );
        $a = str_replace( '\\', '/', $a );
        $b = str_replace( '/Plugins/PaketManager/Magic5AM', '', $a );

        copy($a, $b);
    }

    public function f()
    {
        $this->AssignType();
        PathTools::RecursiveAllFiles($this->pathToPackage, 'ff', $this);
    }
}

new Unpackaging('Magic5AM');