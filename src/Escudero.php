<?php

namespace FimediNET\Escudero;

use FimediNET\Escudero\Tools\Diagnose\FatDiagnose;

class Escudero
{
    const TOOL_FAT_DIAGNOSE = 'fat-diagnose';

    public static function tool($name)
    {
        switch ($name) {
            case self::TOOL_FAT_DIAGNOSE:
                return new FatDiagnose;
                break;
            
            default:
                # code...
                break;
        }
    }
}