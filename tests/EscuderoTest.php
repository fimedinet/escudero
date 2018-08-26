<?php

namespace Tests;

use FimediNET\Escudero\Escudero;
use FimediNET\Escudero\Tools\Diagnose\FatDiagnose;
use FimediNET\Escudero\Tools\Diagnose\SkeletalMuscleDiagnose;
use FimediNET\Escudero\Tools\FrameSize\FrameSizeCalc;
use FimediNET\Escudero\Tools\Weight\WeightCalc;

class EscuderoTest extends BaseTestCase
{
    /**
     * Test it returns a valid class for FatDiagnose
     *
     * @return void
     */
    public function test_it_returns_a_valid_class_for_fat_diagnose()
    {
        $tool = Escudero::tool(Escudero::TOOL_FAT_DIAGNOSE);

        $this->assertInstanceOf(FatDiagnose::class, $tool);
    }

    /**
     * Test it returns a valid class for SkeletalMuscleDiagnose
     *
     * @return void
     */
    public function test_it_returns_a_valid_class_for_skeletal_muscle_diagnose()
    {
        $tool = Escudero::tool(Escudero::TOOL_SKELETAL_MUSCLE_DIAGNOSE);

        $this->assertInstanceOf(SkeletalMuscleDiagnose::class, $tool);
    }

    /**
     * Test it returns a valid class for WeightCalc
     *
     * @return void
     */
    public function test_it_returns_a_valid_class_for_weight_calc()
    {
        $tool = Escudero::tool(Escudero::TOOL_WEIGHT_CALC);

        $this->assertInstanceOf(WeightCalc::class, $tool);
    }

    /**
     * Test it returns a valid class for FrameSizeCalc
     *
     * @return void
     */
    public function test_it_returns_a_valid_class_for_frame_size_calc()
    {
        $tool = Escudero::tool(Escudero::TOOL_FRAME_SIZE_CALC);

        $this->assertInstanceOf(FrameSizeCalc::class, $tool);
    }

    /**
     * Test it returns false if no tool was found
     *
     * @return void
     */
    public function test_it_returns_false_if_no_tool_was_found()
    {
        $tool = Escudero::tool('invalid-tool');

        $this->assertFalse($tool);
    }
}
