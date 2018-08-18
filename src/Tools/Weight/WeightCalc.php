<?php

namespace FimediNET\Escudero\Tools\Weight;

/*
 * Calculate the corresponding weight for a given height at different BMI levels
 */
class WeightCalc
{
    const IDEAL = 'ideal';
    const OVERWEIGHT = 'max';
    const UNDERWEIGHT = 'min';

    private $height;

    public function __construct(array $attributes = null)
    {
        if ($attributes) {
            $this->setHeight($attributes['height']);
        }
    }

    public static function create(int $height)
    {
        return new self(['height' => $height]);
    }

    public function setHeight($height)
    {
        $this->height = floatval($height);
    }

    public function weight($type = self::IDEAL)
    {
        switch (strtolower($type)) {
            case self::OVERWEIGHT:
                $factor = 25;
                break;
            case self::UNDERWEIGHT:
                $factor = 18.5;
                break;
            case self::IDEAL:
            default:
                $factor = 22;
                break;
        }

        $height = $this->height;

        return number_format((($height * $height) * $factor) / 1000000, 1);
    }
}
