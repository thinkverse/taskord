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

function actingAs($user, string $driver = null)
{
    return test()->actingAs(User::find($user), $driver);
}

function faker($property = null)
{
    $faker = Factory::create();

    return $property ? $faker->{$property} : $faker;
}
