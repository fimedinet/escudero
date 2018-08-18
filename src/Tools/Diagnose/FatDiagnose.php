<?php

namespace FimediNET\Escudero\Tools\Diagnose;

use FimediNET\Escudero\Tools\BMI\BMILevel;
use OzdemirBurak\JsonCsv\File\Csv;

/*
 * Diagnose fat levels according to standard tables.
 *
 * Input: gender, age, bmi
 * 
 */
class FatDiagnose
{
    const CHECK_ABOVE = +1;
    const CHECK_BELOW = -1;
    const CHECK_BALANCED = 0;

    private $gender;

    private $age;

    private $table = [];

    private $jsonData = [];

    public function __construct(array $attributes = null)
    {
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }

        $this->initTable();
    }

    public static function create(array $attributes)
    {
        return new self($attributes);
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

    protected function initTable()
    {
        $csv = new Csv(__DIR__ . '/../../../data/fat-ranges.csv');

        $csv->setConversionKey('options', JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        $this->jsonData = json_decode($csv->convert());
    }

    public function getFatRangeString($bmi)
    {
        $range = $this->getFatRange($bmi);

        return "{$range['min']}-{$range['max']}";
    }

    public function getFatRangeFromCategory($bmiLevel)
    {
        $this->jsonData || $this->initTable();

        // Scan the table
        foreach ($this->jsonData as $row) {

            // If BMI level category AND gender is found
            if ($row->category == $bmiLevel && $row->gender == $this->gender) {

                list($minAge, $maxAge) = explode('-', $row->age);

                // If age range is found
                if (intval($minAge) <= $this->age && intval($maxAge) >= $this->age) {

                    // Parse the fat range
                    list($minFat, $maxFat) = explode('-', $row->range);

                    return ['min' => floatval($minFat), 'max' => floatval($maxFat)];
                }
            }
        }

        return false;
    }

    public function getFatRange($bmi)
    {
        $bmiCategory = BMILevel::category($bmi);

        return $this->getFatRangeFromCategory($bmiCategory);
    }

    /*
     * Check if a given fat level is above or below the recommended range
     */
    public function check($bmi, $body_fat)
    {
        $range = $this->getFatRange($bmi);

        if ($range['min'] > floatval($body_fat)) {
            return self::CHECK_BELOW;
        }

        if (floatval($body_fat) > $range['max']) {
            return self::CHECK_ABOVE;
        }

        return self::CHECK_BALANCED;
    }
}
