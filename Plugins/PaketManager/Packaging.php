<?php

/*
Рекурсивним методом встановити всі файли
Записати їх до контексту context
***
назва файлу + шлях
кількість символів
***
компресор
*/

define( 'ABSPATH', __DIR__ . '/../../' );

require_once ABSPATH . 'Tools/PathTools.php';

class Packaging
{
    public $zip;
    public $rootPath;

    function __construct($pathToPath)
    {
        // Get real path for our folder
        $this->rootPath = realpath($pathToPath);

        // Initialize archive object
        $this->zip = new ZipArchive();
        $this->zip->open(basename($pathToPath) . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

        PathTools::RecursiveAllFiles($this->rootPath, 'ZipFiles', $this);

        // Zip archive will be created only after closing object
        $this->zip->close();
    }

    public function ZipFiles($file)
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($this->rootPath) + 1);

        // Add current file to archive
        $this->zip->addFile($filePath, $relativePath);
    }
}

new Packaging(ABSPATH . 'Plugins/Magic5AM');