<?php
namespace library\util;

class Func
{
    public static function str2array($filename)
    {
        if(!file_exists($filename))return false;

        return array_slice(explode("\n",file_get_contents($filename)),0,-1);
    }
}

