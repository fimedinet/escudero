<?php

namespace Tests\Tools\Diagnose;

use FimediNET\Escudero\Tools\Diagnose\FatDiagnose;
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
        $tool = FatDiagnose::create(['age' => 33, 'gender' => 'M']);

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
        $gender = 'M';
        $age = 33;
        $bmi = 18.5;

        $tool = FatDiagnose::create(['age' => $age, 'gender' => $gender]);

        $range = $tool->getFatRangeString($bmi);

        $this->assertRegExp('/[\d\.]+\-[\d\.]+/', $range);
    }
}
