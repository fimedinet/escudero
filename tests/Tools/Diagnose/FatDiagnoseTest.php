<?php

namespace Tests\Tools\Diagnose;

use Faker\Factory;
use FimediNET\Escudero\Tools\BMI\BMILevel;
use FimediNET\Escudero\Tools\Diagnose\FatDiagnose;
use OzdemirBurak\JsonCsv\File\Csv;
use Tests\BaseTestCase;

class FatDiagnoseTest extends BaseTestCase
{
    /**
     * Test a FatDiagnose tool class exists
     *
     * @return void
     */
    public function test_a_fat_diagnose_tool_class_exists()
    {
        $tool = FatDiagnose::create($this->randomProfile());

        $this->assertInstanceOf(FatDiagnose::class, $tool);
    }

    /**
     * Test it retrieves correct range levels from table
     *
     * @return void
     */
    public function test_it_retrieves_correct_range_levels_from_table()
    {
        $tool = FatDiagnose::create(['age' => 33, 'gender' => 'M']);

        $range1 = $tool->getFatRangeString(18);
        $range2 = $tool->getFatRangeString(19);
        $range3 = $tool->getFatRangeString(30);

        $this->assertEquals($range1, '0-8');
        $this->assertEquals($range2, '8-19.9');
        $this->assertEquals($range3, '20-24.9');
    }

    /**
     * Test it retrieves a range level from table
     *
     * @return void
     */
    public function test_it_retrieves_a_range_level_from_table()
    {
        $profile = $this->randomProfile();

        $tool = FatDiagnose::create($profile);

        $range = $tool->getFatRangeString($profile['bmi']);

        $this->assertRegExp('/[\d\.]+\-[\d\.]+/', $range);
    }

    /**
     * Test it uses external fat ranges table from CSV to JSON
     *
     * @return void
     */
    public function test_uses_external_fat_table_from_csv_to_json()
    {
        $tool = FatDiagnose::create($this->randomProfile());

        $jsonData = $this->loadFatRangesStub();

        $tool->useJSONData($jsonData);

        $bmiCategories = [BMILevel::LEVEL_LOW,
                          BMILevel::LEVEL_NORMAL,
                          BMILevel::LEVEL_HIGH,
                          BMILevel::LEVEL_VERY_HIGH,];

        foreach ($bmiCategories as $bmiCategory) {
            $range = $tool->getFatRangeFromCategory($bmiCategory);

            $this->assertInternalType('array', $range);
            $this->assertArrayHasKey('min', $range);
            $this->assertArrayHasKey('max', $range);
            $this->assertInternalType('float', $range['min']);
            $this->assertInternalType('float', $range['max']);
        }
    }

    /**
     * Test it uses autoloaded internal fat ranges table from CSV to JSON
     *
     * @return void
     */
    public function test_uses_autoloaded_internal_fat_table_from_csv_to_json()
    {
        $profile = $this->randomProfile();

        $tool = FatDiagnose::create($profile);

        $bmiCategories = [BMILevel::LEVEL_LOW,
                          BMILevel::LEVEL_NORMAL,
                          BMILevel::LEVEL_HIGH,
                          BMILevel::LEVEL_VERY_HIGH,];

        foreach ($bmiCategories as $bmiCategory) {
            $range = $tool->getFatRangeFromCategory($bmiCategory);

            $this->assertInternalType('array', $range);
            $this->assertArrayHasKey('min', $range);
            $this->assertArrayHasKey('max', $range);
            $this->assertInternalType('float', $range['min']);
            $this->assertInternalType('float', $range['max']);
        }
    }

    /**
     * Test it returns false if profile is not found in table
     *
     * @return void
     */
    public function test_it_returns_false_if_profile_is_not_found_in_table()
    {
        $tool = FatDiagnose::create(['age' => 10, 'gender' => 'X']);

        $bmiCategories = [BMILevel::LEVEL_LOW,
                          BMILevel::LEVEL_NORMAL,
                          BMILevel::LEVEL_HIGH,
                          BMILevel::LEVEL_VERY_HIGH,];

        foreach ($bmiCategories as $bmiCategory) {
            $range = $tool->getFatRangeFromCategory($bmiCategory);

            $this->assertFalse($range);
        }
    }

    /**
     * Test it tells if a given fat level is above or below the recommended range for that profile
     *
     * @return void
     */
    public function test_it_tells_if_a_given_fat_level_is_above_or_below_the_recommended_range_for_that_profile()
    {
        $profile = $this->randomProfile();

        $tool = FatDiagnose::create($profile);

        $range = $tool->getFatRange($profile['bmi']);

        $faker = Factory::create();

        $delta = $faker->numberBetween(1, 5);

        $resultAbove = $tool->check($profile['bmi'], $range['max'] + $delta); // Above maximum in range
        $resultBelow = $tool->check($profile['bmi'], $range['min'] - $delta); // Below minimum in range
        $resultBalanced = $tool->check($profile['bmi'], $range['min'] + $delta); // Inside range

        $this->assertEquals(FatDiagnose::CHECK_ABOVE, $resultAbove);
        $this->assertEquals(FatDiagnose::CHECK_BELOW, $resultBelow);
        $this->assertEquals(FatDiagnose::CHECK_BALANCED, $resultBalanced);
    }

    /////////////
    // HELPERS //
    /////////////

    protected function loadFatRangesStub()
    {
        $csv = new Csv(__DIR__.'/../../../data/fat-ranges.csv');

        $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return json_decode($csv->convert());
    }

    /*
     * Create a random testing profile
     */
    protected function randomProfile() : array
    {
        $faker = Factory::create();

        $gender = $faker->randomElement(['M', 'F']);
        $age = $faker->numberBetween(20, 79);
        $bmi = $faker->numberBetween(17, 50);

        return compact('age', 'gender', 'bmi');
    }
}
