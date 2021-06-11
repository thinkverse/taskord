<?php

use App\Http\Livewire\User\Settings\Profile;
use App\Http\Livewire\User\Settings\Account;
use App\Models\User;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has settings/profile page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings', 302, false],
    ['/settings', 200, true],
]);

it('can edit profile (updateProfile) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Profile::class, ['user' => $newUser])
            ->set('firstname', 'New firstname')
            ->set('lastname', 'New lastaname')
            ->call('updateProfile')
            ->assertEmitted('profileUpdated');
    }

    return actingAs(1)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('firstname', 'New firstname')
        ->set('lastname', 'New lastaname')
        ->call('updateProfile')
        ->assertNotEmitted('profileUpdated');
})->with([
    [true],
    [false],
]);

it('can edit profile (resetAvatar) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Profile::class, ['user' => $newUser])
            ->call('resetAvatar')
            ->assertEmitted('avatarResetted');
    }

    return actingAs(1)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('resetAvatar')
        ->assertNotEmitted('avatarResetted');
})->with([
    [true],
    [false],
]);

it('can edit profile (useGravatar) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Profile::class, ['user' => $newUser])
            ->call('useGravatar')
            ->assertEmitted('gravatarUsed');
    }

    return actingAs(1)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('useGravatar')
        ->assertNotEmitted('gravatarUsed');
})->with([
    [true],
    [false],
]);

it('can edit profile (enableGoal) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Profile::class, ['user' => $newUser])
            ->call('enableGoal')
            ->assertEmitted('goalEnabled');
    }

    return actingAs(1)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('enableGoal')
        ->assertNotEmitted('goalEnabled');
})->with([
    [true],
    [false],
]);

it('can edit profile (toggleVacationMode) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Profile::class, ['user' => $newUser])
            ->call('toggleVacationMode')
            ->assertEmitted('toggledVacationMode');
    }

    return actingAs(1)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('toggleVacationMode')
        ->assertNotEmitted('toggledVacationMode');
})->with([
    [true],
    [false],
]);
