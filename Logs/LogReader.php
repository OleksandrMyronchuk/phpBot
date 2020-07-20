<?php

function LogReader($fileName)
{
    $val = file_get_contents(__DIR__ . '/../' . $fileName);
    $val = htmlspecialchars($val);
    $val = str_replace('\n', '<br/>', $val);
    return $val;
}