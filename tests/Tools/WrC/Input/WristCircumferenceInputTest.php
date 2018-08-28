<?php

namespace Tests\Tools\WrC\Input;

use FimediNET\Escudero\Tools\WrC\Input\WristCircumferenceInput;
use Tests\BaseTestCase;

class WristCircumferenceInputTest extends BaseTestCase
{
    /**
     * Test it accepts Wrist Circumference input in centimeters or milimeters
     *
     * @dataProvider provider
     * 
     * @return void
     */
    public function test_it_accepts_wrist_circumference_input_in_centimeters_or_milimeters($input, $expected)
    {
        $sanitizedWrC = WristCircumferenceInput::sanitize($input);

        $this->assertSame($sanitizedWrC, $expected);
    }

    /**
     * Provides [userInput, expectedOutput] for test case
     * 
     * @return array [userInputWrC, expectedOutputWrC]
     */
    public function provider()
    {
        return [
            [null  , null],
            [''    , null],
            ['0'   , null],
            ['9.5' , 95],
            ['9,5' , 95],
            ['16'  , 160],
            ['16.5', 165],
            ['165' , 165],
            ['200' , 200],
            ['20'  , 200],
            ['350' , 350],
            ['400' , 400],
        ];
    }
}
