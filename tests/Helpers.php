<?php

namespace Tests;

use App\Models\User;
use Faker\Factory;

/**
 * A basic assert example.
 */
function assertExample(): void
{
    test()->assertTrue(true);
}

function actingAs($user = 2, string $driver = null)
{
    return test()->actingAs(User::find($user)->first(), $driver);
}

function faker($property = null)
{
    $faker = Factory::create();

    return $property ? $faker->{$property} : $faker;
}
