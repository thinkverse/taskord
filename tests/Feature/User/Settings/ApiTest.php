<?php

use App\Http\Livewire\User\Settings\Account;
use App\Models\User;
use function Tests\actingAs;

it('has settings/api page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/api', 302, false],
    ['/settings/api', 200, true],
]);

it('can edit account (enrollBeta) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Account::class, ['user' => $newUser])
            ->call('enrollBeta')
            ->assertEmitted('enrolledBeta');
    }

    return actingAs(1)
        ->livewire(Account::class, ['user' => $newUser])
        ->call('enrollBeta')
        ->assertNotEmitted('enrolledBeta');
})->with([
    [true],
    [false],
]);
