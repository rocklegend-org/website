<?php

foreach (new DirectoryIterator(__DIR__.'/'.'Routes') as $file)
{
    if (!$file->isDot() && !$file->isDir() && $file->getFilename() != '.gitignore')
    {
        require_once __DIR__.'/'.'Routes'.'/'.$file->getFilename();
    }
}