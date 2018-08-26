<?php

namespace FimediNET\Escudero\Tools\FrameSize;

use OzdemirBurak\JsonCsv\File\Csv;

/*
 * Calculator for the Frame Size (Physical Structure) from height and wrist circumference
 */
class FrameSizeCalc
{
    /**
     * Gender (Male/Female)
     * 
     * @var string
     */
    private $gender;

    /**
     * Height in milimeters
     * 
     * @var int
     */
    private $height;

    /**
     * Wrist Circumference (WrC) in milimeters
     * 
     * @var int
     */
    private $wrc;

    /**
     * Diagnose table in JSON
     * 
     * @var object
     */
    private $jsonData;

    public function height($height)
    {
        $this->height = $height;

        return $this;
    }

    public function wristCircumference($wrc)
    {
        $this->wrc = $wrc;

        return $this;
    }

    public function gender(string $gender)
    {
        $this->gender = $gender;

        return $this;
    }

    public function calculate()
    {
        $this->jsonData || $this->initTable();

        $frameSizeRatio = $this->height / $this->wrc;

        // Scan the table
        foreach ($this->jsonData as $row) {

            // If Gender Matches
            if ($row->gender == $this->gender) {
                list($minValue, $maxValue) = explode('-', $row->range);

                // If ratio is in range
                if (floatval($minValue) <= $frameSizeRatio && floatval($maxValue) >= $frameSizeRatio) {

                    return $row->frame_size;
                }
            }
        }

        return false;
    }

    public function initTable()
    {
        $filename = $this->dataFilename();

        $csv = new Csv(__DIR__."/../../../data/ranges/{$filename}.csv");

        $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $this->jsonData = json_decode($csv->convert());
    }

    public function dataFilename()
    {
        return 'frame-size';
    }
}
