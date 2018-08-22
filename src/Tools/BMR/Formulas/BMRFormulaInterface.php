<?php

namespace FimediNET\Escudero\Tools\BMR\Formulas;

interface BMRFormulaInterface
{
    public function expression(string $gender);

    public function formulaName() : string;
}
