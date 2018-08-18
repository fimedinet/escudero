<?php

namespace Tests\Tools\BMI;

use FimediNET\Escudero\Tools\BMI\BMILevel;
use Tests\BaseTestCase;

class BMILevelTest extends BaseTestCase
{
    /**
     * Test it returns a valid category for the given BMI
     *
     * @return void
     */
    public function test_it_returns_a_valid_category_for_the_given_bmi()
    {
        $testMatrix = [
            18 => BMILevel::LEVEL_LOW,
            19 => BMILevel::LEVEL_NORMAL,
            26 => BMILevel::LEVEL_HIGH,
            50 => BMILevel::LEVEL_VERY_HIGH,
        ];

        foreach ($testMatrix as $bmi => $categoryCheck) {
            $category = BMILevel::category($bmi);

            $this->assertEquals($category, $categoryCheck);
        }
    }
}
