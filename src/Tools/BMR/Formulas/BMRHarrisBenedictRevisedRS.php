<?php

namespace FimediNET\Escudero\Tools\BMR\Formulas;

use FormulaParser\FormulaParser;
use FimediNET\Escudero\Tools\BMR\Formulas\BMRFormulaInterface;

/*
 * Calculator for Basal Metabolic Rate based on
 * Harris Benedict revised Roza Shizgal formula.
 *
 * Metric calculation.
 *
 * W: Weight (Kg)
 * H: Height (cm)
 * A: Age (years old)
 * 
 */
class BMRHarrisBenedictRevisedRS implements BMRFormulaInterface
{
    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';

    protected $formulas = [
        self::GENDER_MALE   => "88.362 + (13.397 * W) + (4.799 * H) - (5.677 * A)",
        self::GENDER_FEMALE => "447.593 + (9.247 * W) + (3.098 * H) - (4.330 * A)"
    ];

    public function expression(string $gender)
    {
        return $this->formulas[$gender];
    }
}
