<?php

namespace FimediNET\Escudero\Tools\TCN;

/*
 * Calculator for Total Calorie Needs based on physical activity level
 */
class TCNCalc
{
    const ACTIVITY_SEDENTARY = 0;
    const ACTIVITY_LIGHTLY_ACTIVE = 1;
    const ACTIVITY_MODERATELY_ACTIVE = 2;
    const ACTIVITY_VERY_ACTIVE = 3;
    const ACTIVITY_EXTRA_ACTIVE = 4;

    private $bmr;

    private $activity;

    private $palTable = [
        self::ACTIVITY_SEDENTARY         => 1.2,
        self::ACTIVITY_LIGHTLY_ACTIVE    => 1.375,
        self::ACTIVITY_MODERATELY_ACTIVE => 1.55,
        self::ACTIVITY_VERY_ACTIVE       => 1.725,
        self::ACTIVITY_EXTRA_ACTIVE      => 1.9,
    ];

    public function bmr(float $bmr)
    {
        $this->bmr = $bmr;

        return $this;
    }

    public function activityKey(string $activity)
    {
        $this->activity = constant("self::".$activity);

        return $this;
    }

    public function activityID(int $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    public function calculate()
    {
        return $this->bmr * $this->palTable[$this->activity];
    }
}
