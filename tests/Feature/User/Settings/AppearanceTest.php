<?php

use App\Http\Livewire\User\Settings\Api;
use App\Models\User;
use function Tests\actingAs;

it('has settings/appearance page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/appearance', 302, false],
    ['/settings/appearance', 200, true],
]);

it('can edit api (regenerateToken) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Api::class, ['user' => $newUser])
            ->call('regenerateToken')
            ->assertEmitted('refreshApiToken');
    }

    return actingAs(1)
        ->livewire(Api::class, ['user' => $newUser])
        ->call('regenerateToken')
        ->assertNotEmitted('refreshApiToken');
})->with([
    [true],
    [false],
]);
