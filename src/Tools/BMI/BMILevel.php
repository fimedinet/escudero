<?php

namespace FimediNET\Escudero\Tools\BMI;

/*
 * Classify BMI level into a human readable string category
 */
class BMILevel
{
    const LEVEL_LOW = 'LOW';
    const LEVEL_NORMAL = 'NORMAL';
    const LEVEL_HIGH = 'HIGH';
    const LEVEL_VERY_HIGH = 'VERYHIGH';

    public static function category(float $bmi)
    {
        if ($bmi <= 18.5) {
            return self::LEVEL_LOW;
        }

        if ($bmi <= 25) {
            return self::LEVEL_NORMAL;
        }

        if ($bmi <= 30) {
            return self::LEVEL_HIGH;
        }

        return self::LEVEL_VERY_HIGH;
    }
}
