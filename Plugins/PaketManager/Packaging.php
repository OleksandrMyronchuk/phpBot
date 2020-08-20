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

class Packaging
{
    function __construct($pathToPath)
    {
        // Get real path for our folder
        $rootPath = realpath($pathToPath);

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open(basename($pathToPath) . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        // Create recursive directory iterator
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();
    }
}

new Packaging(ABSPATH . 'Plugins/Magic5AM');