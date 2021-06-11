<?php

use App\Http\Livewire\User\Settings\Account;
use App\Models\User;
use function Tests\actingAs;

it('has settings/account page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/account', 302, false],
    ['/settings/account', 200, true],
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
