<?php

namespace FimediNET\Escudero\Tools\Diagnose;

/*
 * Diagnose fat levels according to standard tables.
 *
 * Input: gender, age, bmi
 * 
 */
class FatDiagnose extends RangeDiagnoser
{
    public static function create(array $attributes)
    {
        return new self($attributes);
    }

    public function dataFilename()
    {
        return 'fat-ranges';
    }

    public function getFatRange($bmi)
    {
        return $this->getRange($bmi);
    }

    public function getFatRangeString($bmi)
    {
        return $this->getRangeString($bmi);
    }

    public function getFatRangeFromCategory($category)
    {
        return $this->getRangeFromCategory($category);
    }
}
