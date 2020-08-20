<?php

class PathTools
{
    public static function Path2url($file, $protocol='https://') {
        return $protocol.$_SERVER['HTTP_HOST'].'/'.str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);//realpath!!!!!!!!!!!!!!!!!!!!!
    }

    private static function GetRecursiveDirectory($rootPath)
    {
        // Create recursive directory iterator
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        return $files;
    }

    public static function CreateDirIfNotExist($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }

    public static function RecursiveAllDirs($rootPath, $callback, $currentObj)
    {
        $files = PathTools::GetRecursiveDirectory($rootPath);

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if ($file->isDir())
            {
                call_user_func_array (array($currentObj, $callback), array($file));
            }
        }
    }

    public static function RecursiveAllFiles($rootPath, $callback, $currentObj)
    {
        $files = PathTools::GetRecursiveDirectory($rootPath);

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                call_user_func_array (array($currentObj, $callback), array($file));
            }
        }
    }
}