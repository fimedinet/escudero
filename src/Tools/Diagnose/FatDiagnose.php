<?php

namespace FimediNET\Escudero\Tools\Diagnose;

use FimediNET\Escudero\Tools\BMI\BMILevel;

/*
 * Diagnose fat levels according to standard tables.
 *
 * Input: gender, age, bmi
 * 
 */
class FatDiagnose
{
    private $gender;

    private $age;

    private $table = [];

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

    protected function initTable()
    {
        # GENDER ; AGE RANGE ; FAT RANGE
        $this->table['LOW'] =
        'F;20-39;0-21
        F;40-59;0-23
        F;60-79;0-24
        M;20-39;0-8
        M;40-59;0-11
        M;60-79;0-13';
        $this->table['NORMAL'] =
        'F;20-39;21.0-32.9
        F;40-59;23.0-33.9
        F;60-79;24.0-35.9
        M;20-39;8.0-19.9
        M;40-59;11.0-21.9
        M;60-79;13.0-24.9';
        $this->table['HIGH'] =
        'F;20-39;33-38.9
        F;40-59;34-39.9
        F;60-79;36-41.9
        M;18-39;20-24.9
        M;40-59;22-27.9
        M;60-79;25-29.9';
        $this->table['VERYHIGH'] =
        'F;20-39;33-39
        F;40-59;34-40
        F;60-79;36-42
        M;18-39;20-25
        M;40-59;22-28
        M;60-79;25-30';
    }

    public function getFatRangeString($bmi)
    {
        $range = $this->getFatRange($bmi);

        return "{$range['min']}-{$range['max']}";
    }

    public function getFatRangeFromLevel($bmiLevel)
    {
        logger()->info("Calculated BMI: $bmiLevel");

        $records = explode("\n", $this->table[$bmiLevel]);
        foreach ($records as $record) {
            list($r_gender, $r_ages, $r_values) = explode(';', $record);

            $r_gender = trim($r_gender);

            if ($r_gender == $this->gender) {
                list($r_age_min, $r_age_max) = explode('-', $r_ages);

                if (intval($r_age_min) <= $this->age && $this->age <= intval($r_age_max)) {
                    list($r_val_min, $r_val_max) = explode('-', $r_values);
                    logger()->info("RANGE: $r_val_min - $r_val_max");

                    return ['min' => floatval($r_val_min),
                            'max' => floatval($r_val_max),
                            ];
                }
            }
        }

        return false;
    }

    public function getFatRange($bmi)
    {
        $bmiLevel = BMILevel::category($bmi);

        return $this->getFatRangeFromLevel($bmiLevel);
    }

    public function check($bmi, $body_fat)
    {
        $range = $this->getFatRange($bmi);

        if ($range['min'] > floatval($body_fat)) {
            return -1;
        }

        if (floatval($body_fat) > $range['max']) {
            return +1;
        }

        return 0;
    }
}
