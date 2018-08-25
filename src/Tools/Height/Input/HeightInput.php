<?php

namespace FimediNET\Escudero\Tools\Height\Input;

class HeightInput
{
    /**
     * Sanitize a height value expressed in cm or mm to mm
     * 
     * @param  mixed $value Expression for height in cm or mm
     * @return int          Converted height into mm
     */
    public static function sanitize($value)
    {
        $sanitizedValue = $value;

        $sanitizedValue = str_replace(',', '.', $sanitizedValue);
        $sanitizedValue = str_replace('..', '.', $sanitizedValue);
        $sanitizedValue = str_replace('.', '', $sanitizedValue);

        $sanitizedValue = intval($sanitizedValue);

        if ($sanitizedValue < 199) {
            $sanitizedValue *= 10;
        }

        if ($sanitizedValue < 1000) {
            $sanitizedValue += 1000;
        }

        return $sanitizedValue;
    }
}
