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

    /**
     * Test it returns a valid WHO classification for BMI type
     *
     * @return void
     */
    public function test_it_returns_a_valid_who_classification_for_bmi_type()
    {
        // Sample bmi => expected type
        // Key must be a string later converted to float
        $testMatrix = [
            "15" => BMILevel::TYPE_SEVERE_THINNESS,
            "16.5" => BMILevel::TYPE_MODERATE_THINNESS,
            "18" => BMILevel::TYPE_MILD_THINNESS,
            "24" => BMILevel::TYPE_REGULAR,
            "27" => BMILevel::TYPE_OVERWEIGHT,
            "29" => BMILevel::TYPE_PRE_OBESE,
            "34" => BMILevel::TYPE_OBESE_GRADE_I,
            "39" => BMILevel::TYPE_OBESE_GRADE_II,
            "41" => BMILevel::TYPE_OBESE_GRADE_III,
            "100" => BMILevel::TYPE_OBESE_GRADE_III, // After upper bound limit
        ];

        foreach ($testMatrix as $bmi => $categoryCheck) {
            $type = BMILevel::classification(floatval($bmi));

            $this->assertEquals($type, $categoryCheck);
        }
    }
}
