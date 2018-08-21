<?php

namespace FimediNET\Escudero\Tools\BMR;

use FormulaParser\FormulaParser;

/*
 * Calculator for Basal Metabolic Rate
 */
class BMRCalc
{
    private $gender;

    private $age;

    private $weight;

    private $height;

    private $formula;

    const FORMULA_HARRIS_BENEDICT_ORIGINAL = 'harris-benedict-original';
    const FORMULA_HARRIS_BENEDICT_R_RS = 'harris-benedict-revised-roza-shizgal';
    const FORMULA_HARRIS_BENEDICT_R_MSJ = 'harris-benedict-revised-mifflin-stjeor';

    private $formulas = [
        self::FORMULA_HARRIS_BENEDICT_ORIGINAL => \FimediNET\Escudero\Tools\BMR\Formulas\BMROriginalHarrisBenedict::class,
        self::FORMULA_HARRIS_BENEDICT_R_RS => \FimediNET\Escudero\Tools\BMR\Formulas\BMRHarrisBenedictRevisedRS::class,
        self::FORMULA_HARRIS_BENEDICT_R_MSJ => \FimediNET\Escudero\Tools\BMR\Formulas\BMRHarrisBenedictRevisedMSJ::class,
    ];

    public function formula($formulaName)
    {
        if (array_key_exists($formulaName, $this->formulas)) {
            $this->formula = new $this->formulas[$formulaName]();
        }

        return $this;
    }

    public function gender(string $gender)
    {
        $this->gender = trim(strtoupper($gender));

        return $this;
    }

    public function age(int $age)
    {
        $this->age = intval($age);

        return $this;
    }

    public function height(int $height)
    {
        $this->height = intval($height);

        return $this;
    }

    public function weight(float $weight)
    {
        $this->weight = floatval($weight);

        return $this;
    }

    public function calculate()
    {
        $expression = $this->formula->expression($this->gender);

        $weight = $this->weight;
        $height = $this->height;
        $age = $this->age;

        $parser = new FormulaParser($expression, 2);
        $parser->setValidVariables(['W', 'H', 'A']);
        $parser->setVariables(['W' => $weight, 'H' => $height, 'A' => $age]);
        $result = $parser->getResult();

        return ($result[0] == 'done') ? $result[1] : false;
    }
}
