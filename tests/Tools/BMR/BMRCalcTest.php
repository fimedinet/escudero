<?php

namespace Tests\Tools\BMR;

use FimediNET\Escudero\Tools\BMR\BMRCalc;
use Tests\BaseTestCase;

class BMRCalcTest extends BaseTestCase
{
    /**
     * Test it calculates Basal Metabolic Rate with original formula
     *
     * @return void
     */
    public function test_it_calculates_bmr_original()
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

    /**
     * Test it calculates Basal Metabolic Rate with revised Roza Shizgal formula
     *
     * @return void
     */
    public function test_it_calculates_bmr_revised_roza_shizgal()
    {
        $bmrCalc = new BMRCalc();

        $bmr = $bmrCalc->formula(BMRCalc::FORMULA_HARRIS_BENEDICT_R_RS)
                        ->age(33)
                        ->weight(72.5)
                        ->gender('M')
                        ->height(183.5)
                        ->calculate();

        $this->assertEquals($bmr, 1750.52);
    }

    /**
     * Test it calculates Basal Metabolic Rate with revised Mifflin and St Jeor formula
     *
     * @return void
     */
    public function test_it_calculates_bmr_revised_mifflin_stjeor()
    {
        $bmrCalc = new BMRCalc();

        $bmr = $bmrCalc->formula(BMRCalc::FORMULA_HARRIS_BENEDICT_R_MSJ)
                        ->age(33)
                        ->weight(72.5)
                        ->gender('M')
                        ->height(183.5)
                        ->calculate();

        $this->assertEquals($bmr, 1708.75);
    }
}
