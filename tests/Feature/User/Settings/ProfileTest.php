<?php

use App\Http\Livewire\User\Settings\Profile;
use App\Models\User;
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

it('can edit profile (updateProfile) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('firstname', 'New firstname')
        ->set('lastname', 'New lastaname')
        ->call('updateProfile')
        ->assertEmitted('profileUpdated');
});

it('can edit profile (resetAvatar) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('resetAvatar')
        ->assertEmitted('avatarResetted');
});

it('can edit profile (useGravatar) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('useGravatar')
        ->assertEmitted('gravatarUsed');
});

it('can edit profile (enableGoal) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('enableGoal')
        ->assertEmitted('goalEnabled');
});

it('can edit profile (updateGoal) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('dailyGoal', 10)
        ->call('updateGoal')
        ->assertEmitted('goalUpdated');
});

it('can edit profile (toggleVacationMode) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('toggleVacationMode')
        ->assertEmitted('toggledVacationMode');
});

it('can edit profile (updateSponsor) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('sponsor', 'https://taskord.com/patron')
        ->call('updateSponsor')
        ->assertEmitted('sponsorsUpdated');
});

it('can edit profile (updateSocial) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('website', 'https://taskord.com')
        ->call('updateSocial')
        ->assertEmitted('socialUpdated');
});

it('can edit profile (onlyFollowingsTasks) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('onlyFollowingsTasks')
        ->assertEmitted('toggledOnlyFollowingsTasks');
});
