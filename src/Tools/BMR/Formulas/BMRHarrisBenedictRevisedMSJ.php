<?php

namespace FimediNET\Escudero\Tools\BMR\Formulas;

use FormulaParser\FormulaParser;
use FimediNET\Escudero\Tools\BMR\Formulas\BMRFormulaInterface;

/*
 * Calculator for Basal Metabolic Rate based on
 * Harris Benedict revised Mifflin St Jeor formula.
 *
 * Metric calculation.
 *
 * W: Weight (Kg)
 * H: Height (cm)
 * A: Age (years old)
 * 
 */
class BMRHarrisBenedictRevisedMSJ implements BMRFormulaInterface
{
    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';

    protected $formulas = [
        self::GENDER_MALE   => "(10 * W) + (6.25 * H) - (5 * A) + 5",
        self::GENDER_FEMALE => "(10 * W) + (6.25 * H) - (5 * A) - 161"
    ];

    public function expression(string $gender)
    {
        return $this->formulas[$gender];
    }

    public function formulaName() : string
    {
        return 'Harris Benedict revised by Mifflin and St. Jeor';
    }
}
