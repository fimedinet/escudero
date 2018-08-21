<?php

namespace FimediNET\Escudero\Tools\BMR\Formulas;

use FormulaParser\FormulaParser;
use FimediNET\Escudero\Tools\BMR\Formulas\BMRFormulaInterface;

/*
 * Calculator for Basal Metabolic Rate based on
 * Original Harris Benedict formula.
 *
 * Metric calculation.
 *
 * W: Weight (Kg)
 * H: Height (cm)
 * A: Age (years old)
 * 
 */
class BMROriginalHarrisBenedict implements BMRFormulaInterface
{
    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';
    
    protected $formulas = [
        self::GENDER_MALE   => "66.5 + ( 13.75 * W ) + ( 5.003 * H ) - ( 6.755 * A )",
        self::GENDER_FEMALE => "655.1 + ( 9.563 * W ) + ( 1.850 * H ) - ( 4.676 * A )"
    ];

    public function expression(string $gender)
    {
        return $this->formulas[$gender];
    }
}
