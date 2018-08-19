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
        $classifications = [
            ['limit' => 16.0 , 'type' => self::TYPE_SEVERE_THINNESS],
            ['limit' => 16.99, 'type' => self::TYPE_MODERATE_THINNESS],
            ['limit' => 18.49, 'type' => self::TYPE_MILD_THINNESS],
            ['limit' => 24.99, 'type' => self::TYPE_REGULAR],
            ['limit' => 27.49, 'type' => self::TYPE_OVERWEIGHT],
            ['limit' => 29.99, 'type' => self::TYPE_PRE_OBESE],
            ['limit' => 34.99, 'type' => self::TYPE_OBESE_GRADE_I],
            ['limit' => 39.99, 'type' => self::TYPE_OBESE_GRADE_II],
            ['limit' => 60   , 'type' => self::TYPE_OBESE_GRADE_III],
        ];

        foreach ($classifications as $classification) {
            if ($bmi <= $classification['limit']) {
                return $classification['type'];
            }
        }

        return self::TYPE_OBESE_GRADE_III;
    }
}
