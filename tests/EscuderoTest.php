<?php

namespace Tests;

use FimediNET\Escudero\Escudero;
use FimediNET\Escudero\Tools\Diagnose\FatDiagnose;

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
