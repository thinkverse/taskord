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
});

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
});

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
});

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
});

it('can edit profile (updateGoal) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Profile::class, ['user' => $newUser])
            ->set('dailyGoal', 10)
            ->call('updateGoal')
            ->assertEmitted('goalUpdated');
    }

    return actingAs(1)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('dailyGoal', 10)
        ->call('updateGoal')
        ->assertNotEmitted('goalUpdated');
});

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
});

it('can edit profile (updateSponsor) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Profile::class, ['user' => $newUser])
            ->set('sponsor', 'https://taskord.com/patron')
            ->call('updateSponsor')
            ->assertEmitted('sponsorsUpdated');
    }

    return actingAs(1)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('sponsor', 'https://taskord.com/patron')
        ->call('updateSponsor')
        ->assertNotEmitted('sponsorsUpdated');
});

it('can edit profile (updateSocial) settings', function ($status) {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->set('website', 'https://taskord.com')
        ->call('updateSocial')
        ->assertEmitted('socialUpdated');
});

it('can edit profile (onlyFollowingsTasks) settings', function ($status) {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Profile::class, ['user' => $newUser])
        ->call('onlyFollowingsTasks')
        ->assertEmitted('toggledOnlyFollowingsTasks');
});
