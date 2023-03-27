<?php

spl_autoload_register('al');

function al($className)
{
    $path = 'classes/';
    $ext = ".php";
    $fileName = $path . $className . $ext;

    if (!file_exists($fileName)) {
        $fileName = $className . '.php';
        if (!file_exists($fileName)) {
            return false;
        }
    }

    include_once $fileName;
}
