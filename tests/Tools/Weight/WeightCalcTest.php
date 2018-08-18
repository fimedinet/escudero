<?php

namespace Tests\Tools\Weight;

use FimediNET\Escudero\Tools\Weight\WeightCalc;
use Tests\BaseTestCase;
use Tests\Tools\Diagnose\GeneratesProfileTrait;

class WeightCalcTest extends BaseTestCase
{
    use GeneratesProfileTrait;

    /**
     * Test it returns a valid WeightCalc class
     *
     * @return void
     */
    public function test_it_returns_a_valid_weightcalc_class()
    {
        $weightCalc = new WeightCalc(['height' => 1835]);

        $this->assertInstanceOf(WeightCalc::class, $weightCalc);
    }

    /**
     * Test it calculates the corresponding weight for a given profile at different BMI levels
     *
     * @return void
     */
    public function test_it_calculates_the_corresponding_weight_for_a_given_profile_at_different_bmi_levels()
    {
        $weightCalc = WeightCalc::create(1835);

        $idealWeight = $weightCalc->weight(WeightCalc::IDEAL);

        $overWeightBoundary = $weightCalc->weight(WeightCalc::OVERWEIGHT);

        $underWeightBoundary = $weightCalc->weight(WeightCalc::UNDERWEIGHT);

        $this->assertEquals($idealWeight, 74.1);
        $this->assertEquals($overWeightBoundary, 84.2);
        $this->assertEquals($underWeightBoundary, 62.3);
    }
}
