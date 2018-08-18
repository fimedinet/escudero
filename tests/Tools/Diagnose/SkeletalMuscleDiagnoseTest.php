<?php

namespace Tests\Tools\Diagnose;

use Faker\Factory;
use FimediNET\Escudero\Tools\BMI\BMILevel;
use FimediNET\Escudero\Tools\Diagnose\SkeletalMuscleDiagnose;
use OzdemirBurak\JsonCsv\File\Csv;
use Tests\BaseTestCase;

class SkeletalMuscleDiagnoseTest extends BaseTestCase
{
    use GeneratesProfileTrait;

    /**
     * Test a SkeletalMuscleDiagnose tool class exists
     *
     * @return void
     */
    public function test_a_skeletal_muscle_diagnose_tool_class_exists()
    {
        $tool = SkeletalMuscleDiagnose::create($this->randomProfile());

        $this->assertInstanceOf(SkeletalMuscleDiagnose::class, $tool);
    }

    /**
     * Test it retrieves correct range levels from table
     *
     * @return void
     */
    public function test_it_retrieves_correct_range_levels_from_table()
    {
        $tool = SkeletalMuscleDiagnose::create(['age' => 33, 'gender' => 'M']);

        $range1 = $tool->getSkeletalMuscleRangeString(18);
        $range2 = $tool->getSkeletalMuscleRangeString(19);
        $range3 = $tool->getSkeletalMuscleRangeString(30);

        $this->assertEquals($range1, '0-33.3');
        $this->assertEquals($range2, '33.3-39.3');
        $this->assertEquals($range3, '39.4-44');
    }

    /**
     * Test it retrieves a range level from table
     *
     * @return void
     */
    public function test_it_retrieves_a_range_level_from_table()
    {
        $profile = $this->randomProfile();

        $tool = SkeletalMuscleDiagnose::create($profile);

        $range = $tool->getSkeletalMuscleRangeString($profile['bmi']);

        $this->assertRegExp('/[\d\.]+\-[\d\.]+/', $range);
    }

    /**
     * Test it uses external ranges table from CSV to JSON
     *
     * @return void
     */
    public function test_uses_external_table_from_csv_to_json()
    {
        $tool = SkeletalMuscleDiagnose::create($this->randomProfile());

        $jsonData = $this->loadSkeletalMuscleRangesStub();

        $tool->useJSONData($jsonData);

        $bmiCategories = [BMILevel::LEVEL_LOW,
                          BMILevel::LEVEL_NORMAL,
                          BMILevel::LEVEL_HIGH,
                          BMILevel::LEVEL_VERY_HIGH,];

        foreach ($bmiCategories as $bmiCategory) {
            $range = $tool->getSkeletalMuscleRangeFromCategory($bmiCategory);

            $this->assertInternalType('array', $range);
            $this->assertArrayHasKey('min', $range);
            $this->assertArrayHasKey('max', $range);
            $this->assertInternalType('float', $range['min']);
            $this->assertInternalType('float', $range['max']);
        }
    }

    /**
     * Test it uses autoloaded internal ranges table from CSV to JSON
     *
     * @return void
     */
    public function test_uses_autoloaded_internal_table_from_csv_to_json()
    {
        $profile = $this->randomProfile();

        $tool = SkeletalMuscleDiagnose::create($profile);

        $bmiCategories = [BMILevel::LEVEL_LOW,
                          BMILevel::LEVEL_NORMAL,
                          BMILevel::LEVEL_HIGH,
                          BMILevel::LEVEL_VERY_HIGH,];

        foreach ($bmiCategories as $bmiCategory) {
            $range = $tool->getSkeletalMuscleRangeFromCategory($bmiCategory);

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
        $tool = SkeletalMuscleDiagnose::create(['age' => 10, 'gender' => 'X']);

        $bmiCategories = [BMILevel::LEVEL_LOW,
                          BMILevel::LEVEL_NORMAL,
                          BMILevel::LEVEL_HIGH,
                          BMILevel::LEVEL_VERY_HIGH,];

        foreach ($bmiCategories as $bmiCategory) {
            $range = $tool->getSkeletalMuscleRangeFromCategory($bmiCategory);

            $this->assertFalse($range);
        }
    }

    /**
     * Test it tells if a given fat level is above or below the recommended range for that profile
     *
     * @return void
     */
    public function test_it_tells_if_a_given_level_is_above_or_below_the_recommended_range_for_that_profile()
    {
        $profile = $this->randomProfile();

        $tool = SkeletalMuscleDiagnose::create($profile);

        $range = $tool->getSkeletalMuscleRange($profile['bmi']);

        $faker = Factory::create();

        $delta = $faker->numberBetween(1, 5);

        $resultAbove = $tool->check($profile['bmi'], $range['max'] + $delta); // Above maximum in range
        $resultBelow = $tool->check($profile['bmi'], $range['min'] - $delta); // Below minimum in range
        $resultBalanced = $tool->check($profile['bmi'], $range['min'] + $delta); // Inside range

        $this->assertEquals(SkeletalMuscleDiagnose::CHECK_ABOVE, $resultAbove);
        $this->assertEquals(SkeletalMuscleDiagnose::CHECK_BELOW, $resultBelow);
        $this->assertEquals(SkeletalMuscleDiagnose::CHECK_BALANCED, $resultBalanced);
    }

    /////////////
    // HELPERS //
    /////////////

    protected function loadSkeletalMuscleRangesStub()
    {
        $csv = new Csv(__DIR__.'/../../../data/ranges/skeletal-muscle.csv');

        $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return json_decode($csv->convert());
    }
}
