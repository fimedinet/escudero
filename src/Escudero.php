<?php

namespace FimediNET\Escudero;

use FimediNET\Escudero\Tools\Diagnose\FatDiagnose;
use FimediNET\Escudero\Tools\Diagnose\SkeletalMuscleDiagnose;

class Escudero
{
    const TOOL_FAT_DIAGNOSE = 'fat-diagnose';
    const TOOL_SKELETAL_MUSCLE_DIAGNOSE = 'skeletal-muscle-diagnose';

    public static function tool($name)
    {
        switch ($name) {
            case self::TOOL_FAT_DIAGNOSE:
                return new FatDiagnose();
            case self::TOOL_SKELETAL_MUSCLE_DIAGNOSE:
                return new SkeletalMuscleDiagnose();

            default:
                return false;
        }
    }
}
