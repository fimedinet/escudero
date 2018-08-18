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

    const TYPE_SEVERE_THINNESS = -3;
    const TYPE_MODERATE_THINNESS = -2;
    const TYPE_MILD_THINNESS = -1;
    const TYPE_REGULAR = 0;
    const TYPE_OVERWEIGHT = 1;
    const TYPE_PRE_OBESE = 2;
    const TYPE_OBESE_GRADE_I = 3;
    const TYPE_OBESE_GRADE_II = 4;
    const TYPE_OBESE_GRADE_III = 5;

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

    public static function classification(float $bmi) : int
    {
        if ($bmi <= 16.00) {
            return self::TYPE_SEVERE_THINNESS;
        }

        if ($bmi <= 16.99) {
            return self::TYPE_MODERATE_THINNESS;
        }

        if ($bmi <= 18.49) {
            return self::TYPE_MILD_THINNESS;
        }

        if ($bmi <= 24.99) {
            return self::TYPE_REGULAR;
        }

        if ($bmi <= 27.49) {
            return self::TYPE_OVERWEIGHT;
        }

        if ($bmi <= 29.99) {
            return self::TYPE_PRE_OBESE;
        }

        if ($bmi <= 34.99) {
            return self::TYPE_OBESE_GRADE_I;
        }

        if ($bmi <= 39.99) {
            return self::TYPE_OBESE_GRADE_II;
        }

        if ($bmi >= 40) {
            return self::TYPE_OBESE_GRADE_III;
        }
    }
}
