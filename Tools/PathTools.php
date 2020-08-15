<?php

class PathTools
{
    public static function Path2url($file, $protocol='https://') {
        return $protocol.$_SERVER['HTTP_HOST'].'/'.str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
    }
}