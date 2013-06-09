<?php

class RUtils
{
    public static function cleanFileName($filename)
    {
        $chars_to_remove = array(" ", '"', "'", "&", "/", "\\", "?", "#");
        return str_replace($chars_to_remove, '_', $filename);
    }
}


?>;