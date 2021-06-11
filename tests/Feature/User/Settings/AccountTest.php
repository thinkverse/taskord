<?php

use App\Http\Livewire\User\Settings\Account;
use App\Models\User;
use function Tests\actingAs;
use Illuminate\Support\Str;

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

it('can edit account (enrollPrivate) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Account::class, ['user' => $newUser])
            ->call('enrollPrivate')
            ->assertEmitted('enrolledPrivate');
    }

    return actingAs(1)
        ->livewire(Account::class, ['user' => $newUser])
        ->call('enrollPrivate')
        ->assertNotEmitted('enrolledPrivate');
})->with([
    [true],
    [false],
]);

it('can edit account (updateAccount) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Account::class, ['user' => $newUser])
            ->set('email', Str::random(8).'@gmail.com')
            ->set('username', Str::random(8))
            ->call('updateAccount')
            ->assertEmitted('accountUpdated');
    }

    return actingAs(1)
        ->livewire(Account::class, ['user' => $newUser])
        ->set('email', Str::random(8).'@gmail.com')
        ->set('username', Str::random(8))
        ->call('updateAccount')
        ->assertNotEmitted('accountUpdated');
})->with([
    [true],
    [false],
]);
