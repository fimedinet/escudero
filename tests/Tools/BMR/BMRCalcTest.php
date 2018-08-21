<?php

namespace Tests\Tools\BMR;

use FimediNET\Escudero\Tools\BMR\BMRCalc;
use Tests\BaseTestCase;

class BMRCalcTest extends BaseTestCase
{
    /**
     * Test it calculates Basal Metabolic Rate
     *
     * @return void
     */
    public function test_it_calculates_bmr()
    {
        $bmrCalc = new BMRCalc();

        $bmr = $bmrCalc->formula(BMRCalc::FORMULA_HARRIS_BENEDICT_ORIGINAL)
                        ->age(33)
                        ->weight(72.5)
                        ->gender('M')
                        ->height(183.5)
                        ->calculate();

        $this->assertEquals($bmr, 1756.01);
    }
}