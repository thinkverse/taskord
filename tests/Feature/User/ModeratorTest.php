<?php

use App\Http\Livewire\User\Moderator;
use App\Models\User;
use function Tests\actingAs;

it('can edit (enrollBeta) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollBeta')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollBeta')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (enrollStaff) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollStaff')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollStaff')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (enrollDeveloper) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollDeveloper')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollDeveloper')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (privateUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('privateUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('privateUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (flagUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('flagUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('flagUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (suspendUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('suspendUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('suspendUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (enrollPatron) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollPatron')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollPatron')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (verifyUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('verifyUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('verifyUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);
