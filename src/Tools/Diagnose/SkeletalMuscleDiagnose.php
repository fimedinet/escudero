<?php

namespace FimediNET\Escudero\Tools\Diagnose;

/*
 * Diagnose skeletal muscle levels according to standard tables.
 *
 * Input: gender, age, bmi
 * 
 */
class SkeletalMuscleDiagnose extends RangeDiagnoser
{
    public static function create(array $attributes)
    {
        return new self($attributes);
    }

    public function dataFilename()
    {
        return 'skeletal-muscle-ranges';
    }

    public function getSkeletalMuscleRange($bmi)
    {
        return $this->getRange($bmi);
    }

    public function getSkeletalMuscleRangeString($bmi)
    {
        return $this->getRangeString($bmi);
    }

    public function getSkeletalMuscleRangeFromCategory($category)
    {
        return $this->getRangeFromCategory($category);
    }
}
