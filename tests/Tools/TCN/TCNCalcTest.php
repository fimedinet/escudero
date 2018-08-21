<?php

namespace Tests\Tools\TCN;

use FimediNET\Escudero\Tools\BMR\BMRCalc;
use FimediNET\Escudero\Tools\TCN\TCNCalc;
use Tests\BaseTestCase;

class TCNCalcTest extends BaseTestCase
{
    /**
     * Test it calculates Total Calorie Needs based on physical activity level
     *
     * @return void
     */
    public function test_it_calculates_total_calorie_needs_based_on_physical_activity_level()
    {
        $bmrCalc = new BMRCalc();

        $bmr = $bmrCalc->formula(BMRCalc::FORMULA_HARRIS_BENEDICT_ORIGINAL)
                        ->age(33)
                        ->weight(72.5)
                        ->gender('M')
                        ->height(183.5)
                        ->calculate();

        $tcnCalc = new TCNCalc;

        $tcn = $tcnCalc->bmr($bmr)->activity(TCNCalc::ACTIVITY_SEDENTARY)->calculate();

        $this->assertEquals($tcn, 2107.212);
    }
}
