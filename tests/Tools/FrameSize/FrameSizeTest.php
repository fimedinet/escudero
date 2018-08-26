<?php

namespace Tests\Tools\FrameSize;

use FimediNET\Escudero\Tools\FrameSize\FrameSizeCalc;
use Tests\BaseTestCase;

class FrameSizeTest extends BaseTestCase
{
    /**
     * Test it calculates Frame Size category from Gender, Height and Wrist Circumference
     *
     * @dataProvider provider
     * 
     * @return void
     */
    public function test_calculates_frame_size_category_from_gender_height_and_wrist_circumference($gender, $height, $wrc, $expectedFrameSize)
    {
        $FSCalc = new FrameSizeCalc();

        $calculatedFrameSize = $FSCalc->gender($gender)->height($height)->wristCircumference($wrc)->calculate();

        $this->assertEquals($calculatedFrameSize, $expectedFrameSize);
    }

    public function provider()
    {
        return [
            ['M', 1835, 160, 'SMALL'],
            ['M', 1835, 180, 'MEDIUM'],
            ['M', 1835, 200, 'LARGE'],
            ['M', 1200,  90, 'SMALL'],
            ['M', 1200, 120, 'MEDIUM'],
            ['M', 1200, 130, 'LARGE'],
            ['F', 1835, 130, 'SMALL'],
            ['F', 1835, 170, 'MEDIUM'],
            ['F', 1835, 300, 'LARGE'],
            ['F', 1200,  80, 'SMALL'],
            ['F', 1200, 110, 'MEDIUM'],
            ['F', 1200, 130, 'LARGE'],
        ];
    }
}
