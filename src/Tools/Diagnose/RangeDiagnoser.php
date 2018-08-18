<?php

namespace FimediNET\Escudero\Tools\Diagnose;

use FimediNET\Escudero\Tools\BMI\BMILevel;
use OzdemirBurak\JsonCsv\File\Csv;

/*
 * Range diagnoser.
 *
 * Input: gender, age, bmi
 * 
 */
abstract class RangeDiagnoser
{
    const CHECK_ABOVE = +1;
    const CHECK_BELOW = -1;
    const CHECK_BALANCED = 0;

    public $gender;

    public $age;

    public $jsonData = [];

    public function __construct(array $attributes = null)
    {
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }

        $this->initTable();
    }

    abstract public function dataFilename();

    public function initTable()
    {
        $filename = $this->dataFilename();

        $csv = new Csv(__DIR__."/../../../data/ranges/{$filename}.csv");

        $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $this->jsonData = json_decode($csv->convert());
    }

    public function setAttributes(array $attributes)
    {
        $this->gender = $attributes['gender'];
        $this->age = $attributes['age'];
    }

    public function useJSONData($data)
    {
        $this->jsonData = $data;
    }

    public function getRangeString($bmi)
    {
        $range = $this->getRange($bmi);

        return "{$range['min']}-{$range['max']}";
    }

    public function getRangeFromCategory($bmiLevel)
    {
        $this->jsonData || $this->initTable();

        // Scan the table
        foreach ($this->jsonData as $row) {

            // If BMI level category AND gender is found
            if ($row->category == $bmiLevel && $row->gender == $this->gender) {

                list($minAge, $maxAge) = explode('-', $row->age);

                // If age range is found
                if (intval($minAge) <= $this->age && intval($maxAge) >= $this->age) {

                    // Parse the range values
                    list($minValue, $maxValue) = explode('-', $row->range);

                    return ['min' => floatval($minValue), 'max' => floatval($maxValue)];
                }
            }
        }

        return false;
    }

    public function getRange($bmi)
    {
        $bmiCategory = BMILevel::category($bmi);

        return $this->getRangeFromCategory($bmiCategory);
    }

    /*
     * Check if a given level is above or below the recommended range
     */
    public function check($bmi, $value)
    {
        $range = $this->getRange($bmi);

        if ($range['min'] > floatval($value)) {
            return self::CHECK_BELOW;
        }

        if (floatval($value) > $range['max']) {
            return self::CHECK_ABOVE;
        }

        return self::CHECK_BALANCED;
    }
}
