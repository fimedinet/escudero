<?php

namespace FimediNET\Escudero;

use FimediNET\Escudero\Tools\Diagnose\FatDiagnose;
use FimediNET\Escudero\Tools\Diagnose\SkeletalMuscleDiagnose;
use FimediNET\Escudero\Tools\FrameSize\FrameSizeCalc;
use FimediNET\Escudero\Tools\Weight\WeightCalc;

class Escudero
{
    const TOOL_FAT_DIAGNOSE = 'fat-diagnose';
    const TOOL_SKELETAL_MUSCLE_DIAGNOSE = 'skeletal-muscle-diagnose';
    const TOOL_WEIGHT_CALC = 'weight-calc';
    const TOOL_FRAME_SIZE_CALC = 'frame-size-calc';

    public static function tool($name)
    {
        switch ($name) {
            case self::TOOL_FAT_DIAGNOSE:
                return new FatDiagnose();
            case self::TOOL_SKELETAL_MUSCLE_DIAGNOSE:
                return new SkeletalMuscleDiagnose();
            case self::TOOL_WEIGHT_CALC:
                return new WeightCalc();
            case self::TOOL_FRAME_SIZE_CALC:
                return new FrameSizeCalc();
            default:
                return false;
        }
    }
}
