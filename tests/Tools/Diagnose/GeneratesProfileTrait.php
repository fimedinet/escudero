<?php

namespace Tests\Tools\Diagnose;

use Faker\Factory;

trait GeneratesProfileTrait
{
    /*
     * Create a random testing profile
     */
    protected function randomProfile() : array
    {
        $faker = Factory::create();

        $gender = $faker->randomElement(['M', 'F']);
        $age = $faker->numberBetween(20, 79);
        $bmi = $faker->numberBetween(17, 50);

        return compact('age', 'gender', 'bmi');
    }
}
