<?php

namespace FimediNET\Escudero\Tools\WrC\Input;

class WristCircumferenceInput
{
    /**
     * Sanitize a Wrist Circumference value expressed in cm or mm to mm
     * 
     * @param  mixed $value Expression for Wrist Circumference in cm or mm
     *
     * @return int          Converted Wrist Circumference into mm
     */
    public static function sanitize($value)
    {
        if (empty($value)) {
            return;
        }

        $sanitizedValue = $value;

        $sanitizedValue = str_replace(',', '.', $sanitizedValue);
        $sanitizedValue = str_replace('..', '.', $sanitizedValue);
        $sanitizedValue = str_replace('.', '', $sanitizedValue);

        $sanitizedValue = floatval($sanitizedValue);

        if ($sanitizedValue < 10) {
            $sanitizedValue *= 10;
        }

        if ($sanitizedValue < 40) {
            $sanitizedValue *= 10;
        }

        return intval($sanitizedValue);
    }
}
