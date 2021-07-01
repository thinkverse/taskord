<?php

use App\Http\Livewire\User\Settings\Delete;
use App\Models\User;
use function Tests\actingAs;

it('has settings/delete page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/delete', 302, false],
    ['/settings/delete', 200, true],
]);

it('can reset the account', function ($status) {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Delete::class, ['user' => $newUser])
        ->call('resetAccount')
        ->assertEmitted('accountResetted');
});

it('can delete the account', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Delete::class, ['user' => $newUser])
            ->call('deleteAccount')
            ->assertEmitted('accountDeleted');
    }

    return actingAs(1)
        ->livewire(Delete::class, ['user' => $newUser])
        ->call('deleteAccount')
        ->assertNotEmitted('accountDeleted');
})->with([
    [true],
    [false],
]);
