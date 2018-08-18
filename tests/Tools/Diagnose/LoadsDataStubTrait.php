<?php

namespace Tests\Tools\Diagnose;

use Faker\Factory;
use OzdemirBurak\JsonCsv\File\Csv;

trait LoadsDataStubTrait
{
    protected function loadRangesStub($filename)
    {
        $csv = new Csv(__DIR__."/../../../data/ranges/{$filename}.csv");

        $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return json_decode($csv->convert());
    }
}
