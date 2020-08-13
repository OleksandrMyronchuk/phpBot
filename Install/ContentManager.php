<?php

function GetContent()
{
echo 'ok';
}

function SaveContent($data)
{

}

if(!empty($_POST['functionName']))
{
    $functionName = $_POST['functionName'];
    if($functionName == 'GetContent')
    {
        return GetContent();
    }
}
