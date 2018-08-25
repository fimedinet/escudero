<?php

namespace Tests\Tools\Height\Input;

use FimediNET\Escudero\Tools\Height\Input\HeightInput;
use Tests\BaseTestCase;

class HeightInputTest extends BaseTestCase
{
    /**
     * Test it accepts height input in any metric unit
     *
     * @dataProvider provider
     * 
     * @return void
     */
    public function test_it_accepts_height_input_in_milimeters($input, $expected)
    {
        $sanitizedHeight = HeightInput::sanitize($input);

        $this->assertEquals($sanitizedHeight, $expected);
    }

    /**
     * Provides [userInput, expectedOutput] for test case
     * 
     * @return array [userInputHeight, expectedOutputHeight]
     */
    public function provider()
    {
        return [
            ['1835' , 1835],  // Expressed in milimeters
            ['183'  , 1830],  // Expressed in centimeters
            ['1.83' , 1830],  // Expressed in meters
            ['1.835', 1835],  // Expressed in meters
            ['835',   1835],  // Expressed in centimeters with implicit meters
            ['2.155', 2155],  // Expressed in meters above 2mt
            ['60',    1600],  // Expressed in cm with implicit meters
            ['1,835', 1835],  // Expressed in meters with coma as decimal separator
            ['1..835', 1835],  // Expressed in meters with accidental double decimal separator
            ['1,,835', 1835],  // Expressed in meters with accidental double coma decimal separator
            [' 1.835 ', 1835], // Expressed in meters with side extra spaces
        ];
    }
}
